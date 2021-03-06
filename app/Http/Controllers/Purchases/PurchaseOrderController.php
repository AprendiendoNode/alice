<?php

namespace App\Http\Controllers\Purchases;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use PDF;
use App\Helpers\Helper;
use App\Cadena;
use App\Models\Projects\Documentp;
use App\Models\Projects\In_Documentp_cart;
use App\ConvertNumberToLetters;
use Carbon\Carbon;

class PurchaseOrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $providers = DB::table('customers')->select('id', 'name')->where('provider', 1)->orderBy('name')->get();
        $direcciones = DB::table('order_address_delivery')->select('id', 'address')->get();
        $currency = DB::select('CALL GetAllCurrencyActivev2 ()');  
        
        $projects = DB::table('documentp')->select('id', 'folio', 'status_id')
        ->where('status_id', '=', '3')
        ->where('doc_type', '!=', '3')
        ->orderBy('created_at', 'DESC')
        ->get();
        //dd($projects);            
        return view('permitted.purchases.order_purchase_view', compact('providers', 'currency', 'projects', 'direcciones'));
    }

    public function view_history_order_purchases()
    {
        $providers = DB::table('customers')->select('id', 'name')->where('provider', 1)->orderBy('name')->get();
               
        return view('permitted.purchases.history_order_purchases', compact('providers'));
    }

    public function get_history_purchases_order(Request $request)
    {
        $date = strtotime($request->date);
        $date = date("Y-m-d", $date);
        $date_to = strtotime($request->filter_date_to);
        $date_to = date("Y-m-d", $date_to);
        $result = DB::select('CALL px_order_purchase_all_xmes(?,?)', array($date, $date_to));

        return $result;
    }

    public function get_products_by_cart_order($id_cart)
    {
        $result = DB::select('CALL px_order_cart_products_xorder_cart(?)', array($id_cart));

        return result;
    }

    public function print_order_purchase($id_order_shop, $id_cart)
    {        
        $products = DB::select('CALL px_order_cart_products_xorder_cart(?)', array($id_cart));
        $order_purchases = DB::select('CALL px_order_purchase_data(?)', array($id_order_shop));
        $format = new ConvertNumberToLetters();
        
        $ammount_letter = $format->convertir($order_purchases[0]->total);

        $pdf = PDF::loadView('permitted.purchases.order_purchase_pdf', compact('ammount_letter', 'products', 'order_purchases'));

        return $pdf->stream();
    }

    public function store(Request $request)
    {   
        $date = \Carbon\Carbon::now();
        $date = $date->format('Y-m-d');
        $date_delivery =  Carbon::parse($request->date_delivery)->format('Y-m-d');
        $folio = $this->createFolio();
        $provider_id = $request->provider_id;
        //Objeto de productos
        $products = $request->products;
        $products_data = json_decode($products);
        
        $tam_products = count($products_data);
        $flag = "false";

        if($request->provider_id == 92 || $request->provider_id == 992){
            $provider_id = $request->provider_divesos_id;
        }

        DB::beginTransaction();

        try {
            //Creado carrito de orden de compra
            $id_order_cart = DB::table('order_cart')->insertGetId([
                'created_at' => \Carbon\Carbon::now()
            ]);         

            //Insertando productos al carrito de orden de compras
            for ($i=0; $i < $tam_products; $i++)
            {
                $sql = DB::table('order_cart_products')->insert([
                    'order_cart_id' => $id_order_cart,
                    'product_id' => $products_data[$i]->product_id,
                    'cantidad' => $products_data[$i]->cantidad,
                    'precio' => $products_data[$i]->precio,
                    'subtotal' => $products_data[$i]->subtotal,
                    'descuento' => $products_data[$i]->descuento,
                    'descuento_percent' => $products_data[$i]->descuento_percent,
                    'total' => $products_data[$i]->total,
                    'created_at' => \Carbon\Carbon::now()
                ]);
            }

            $order_purchase = DB::table('order_purchase')->insertGetId([
                'num_order' => $folio,
                'date_delivery' => $date_delivery,
                'date' => $date,
                'referencia' => $request->reference,
                'order_address_delivery_id' => $request->address_delivery_id,
                'order_cart_id' => $id_order_cart,
                'order_status_id' => 1,
                'provider_id' => $provider_id,
                'tax_id' => 1,
                'subtotal' => $request->subtotal,
                'descuento' => $request->descuento,
                'iva_amount' => $request->iva,
                'total' => $request->total,
                'id_doc' => $request->id_doc
            ]);

            DB::commit();

            $flag = "true";


        } catch(\Exception $e){
            $error = $e->getMessage();
            DB::rollback();
            dd($error);
        }

        return  $flag;
    }

    public function getProvidersFromProject($doc_id)
    {
        $providers = DB::select('CALL px_proveedores_documentp_xid(?)', array($doc_id));

        return $providers;
    }

    public function getDiversosProvidersFromProject($doc_id)
    {
        $providers = DB::select('CALL px_proveedores_diversos_documentp_xid(?)', array($doc_id));

        return $providers;
    }

    public function getProductsFromProjectsByProvider($doc_id, $provider_id)
    {
        
        $documentp = Documentp::findOrFail($doc_id);
        $cart_id = $documentp->documentp_cart_id;

        $products = DB::select('CALL px_in_documentp_cart_products_xprov(?,?)', array($cart_id, $provider_id));
        
        return $products;
    }
   
    public function getProductsFromProjectsByProviderDiverso($doc_id, $provider_id)
    {
        
        $documentp = Documentp::findOrFail($doc_id);
        $cart_id = $documentp->documentp_cart_id;

        $products = DB::select('CALL px_in_documentp_cart_products_xprov_diverso(?,?)', array($cart_id, $provider_id));
        
        return $products;
    }

    public function show($id)
    {
        // 
    }

    public function edit($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        //
    }

    public function destroy(Request $request)
    {
        $flag = "3";
        
        if(auth()->user()->can('Delete purchase orders')) {

            DB::beginTransaction();

            try {
                $order_purchase = DB::table('order_purchase')->select('id','order_cart_id')->where('id', $request->id)->get();
                
                DB::table('order_cart_products')->where('order_cart_id', '=', $order_purchase[0]->order_cart_id)->delete();
                DB::table('order_purchase')->where('id', '=',$order_purchase[0]->id)->delete();
                DB::table('order_cart')->where('id', '=' ,$order_purchase[0]->order_cart_id)->delete();
                        
                DB::commit();

            }catch(\Exception $e){
                $error = $e->getMessage();
                DB::rollback();
                dd($error);
            }

            $flag = "1"; //Orden de compra eliminada correctamente

        }else{
            $flag = "2"; //No tiene permisos para borrar ordenes de compra
        }
        
        return  $flag; 
    }

    public function add_address_delivery(Request $request)
    {
        $result = DB::table('order_address_delivery')->insert([
            'address' => $request->new_address
        ]);
    }
    
    public function setStatusOrder(Request $request)
    {
        $order = $result = DB::table('order_purchase')
        ->where('id', $request->id)
        ->update([
            'order_status_id' => $request->status
        ]);

        return response()->json([
            'status' => 200
        ]);
    } 

    public function createFolio()
    {
        $nomenclatura = "OCQR-";
        $current_date = date('Y-m-d');
        date_default_timezone_set('America/Cancun');
        setlocale(LC_TIME, 'es_ES', 'esp_esp');
        $complemento= strtoupper(strftime("%b%y", strtotime($current_date)));

        $res = DB::table('order_purchase')->latest()->first();
        if (empty($res)) {
        $nomenclatura = $nomenclatura.$complemento.'-'."0000001";

        return $nomenclatura;

        } else {
            $folio_latest = $res->num_order;

            if (empty($folio_latest)) {
                $nomenclatura = $nomenclatura.$complemento.'-'."0000001";
                return $nomenclatura;
            } else {
                $explode = explode('-', $folio_latest);
                
                $num_folio = (int)$explode[2];
                $num_folio = $num_folio + 1;
                $digits = strlen($num_folio);

                switch ($digits) {
                case 1:
                    $num_folio = (string)$nomenclatura .$complemento.'-'. "000000" . $num_folio;
                    break;
                case 2:
                    $num_folio = (string)$nomenclatura .$complemento.'-'. "00000" . $num_folio;
                    break;
                case 3:
                    $num_folio = (string)$nomenclatura .$complemento.'-'. "0000" . $num_folio;
                    break;
                case 4:
                    $num_folio = (string)$nomenclatura .$complemento.'-'. "000" . $num_folio;
                    break;
                case 5:
                    $num_folio = (string)$nomenclatura .$complemento.'-'. "00" . $num_folio;
                    break;
                case 6:
                    $num_folio = (string)$nomenclatura .$complemento.'-'. "0" . $num_folio;
                    break;
                default:
                    $num_folio = (string)$nomenclatura .$complemento.'-'. $num_folio;
                    break;
                }
                return (string)$num_folio;
            }
        }
    }


}

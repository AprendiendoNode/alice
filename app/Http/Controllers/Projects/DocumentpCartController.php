<?php

namespace App\Http\Controllers\Projects;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use \Illuminate\Pagination\Paginator;
use \Illuminate\Support\Collection;
use \Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use App\Models\Projects\Documentp;
use App\Models\Projects\In_Documentp_cart;
use App\Models\Catalogs\Product;
use Auth;
use DB;

class DocumentpCartController extends Controller
{
    public function index(Request $request)
    {
        $categories = DB::table('products_categories')->select('id', 'name')->get();
        $grupos = DB::table('cadenas')->select('id', 'name')->orderBy('name')->get();
        $verticals = DB::table('verticals')->select('id','name')->get();
        $itc = DB::select('CALL px_ITC_todos_V2');
        $comerciales = DB::select('CALL px_resguardoXgrupo_users(?)', array(2));
        $type_service = DB::table('documentp_type')->select('id', 'name')->get();
        $installation = DB::table('documentp_installation')->select('id', 'name')->get();
        $product_sw = DB::select('CALL px_products_swiches');
        $product_ap = DB::select('CALL px_products_antenas');
        $product_fw = DB::select('CALL px_products_firewalls');
        $products_bobinas = DB::table('products')->where('name', 'LIKE', '%bobina%')->get();
        $products_gabinetes = DB::table('products')->where('name', 'LIKE', '%gabinete%')->get();
        $materiales = DB::table('product_material')->get();
        $medidas = DB::table('product_measure')->get();
        
        return view('permitted.documentp.documentp_cart', compact('grupos', 'verticals', 'itc','products_bobinas','materiales', 'medidas',
              'products_gabinetes', 'categories', 'type_service', 'installation','comerciales' ,'product_ap', 'product_sw', 'product_fw'));

    }

   /**
   **  Funcion para obtener los diferentes tipos de Materiales y Equipo activo
   ** segun el parametro enviado
   */

    public function getItemType($type, $aps, $api, $ape, $firewalls, $switches, $switch_cant)
    {

        if ($type == 'first') {
        $products = DB::select('CALL px_products_propuesta_equipoactivo(?,?)', array($api,$ape));
        $products_eq_activo =  $this->paginate($products, $perPage = 10,  null , $options = []);

        return view('permitted.documentp.products_eqactivo', ['products_eq_activo' => $products_eq_activo])->render();         

        } else if ($type == 'second') {
          $products_m = DB::select('CALL px_antenas_internas_materiales(?,?,?,?,?,?)', array($api, $ape, $switch_cant));
          //dd($products_m);
          $products_materiales =  $this->paginate($products_m, $perPage = 12,  null , $options = []);

          return view('permitted.documentp.products_materiales', ['products_materiales' => $products_materiales])->render();

        }

    }

    public function getItemTypeMaterials($type, $api, $ape, $switch_cant, $gabinetes, $material, $medida)
    {
       $id_user = Auth::user()->id;

        if ($type == 'second') {
          $products_m = DB::select('CALL px_antenas_int_ext_materiales(?,?,?,?,?,?)', array($api, $ape,$switch_cant, $gabinetes, $material, $medida));
          
          $products_materiales =  $this->paginate($products_m, $perPage = 12,  null , $options = []);
          //dd($products_materiales);
          return view('permitted.documentp.products_materiales', ['products_materiales' => $products_materiales])->render();

        }

    }

    public function getMoProducts($api, $ape)
    {
        $cant_aps = $api + $ape;
        $products_m = DB::select('CALL px_products_propuesta_manoobra(?)', array($cant_aps));

        return $products_m;
    }

    public function getMoProductsCart($api, $ape, $id_doc)
    {
        $docp = Documentp::find($id_doc);
        $cart = $docp->documentp_cart_id;
        $cant_aps = $api + $ape;
        $products_m = DB::select('CALL px_products_propuesta_manoobra_idprod(?, ?)', array($cant_aps, $cart));

        return $products_m;
    }

    public function getViaticsProducts($api, $ape)
    {
        $cant_aps = $api + $ape;
        $products_m = DB::select('CALL px_products_propuesta_manoobra_viaticos(?)', array($cant_aps));

        return $products_m;
    }

    public function createTableTempEA($aps ,$firewalls, $switches)
    {
      $id_user = Auth::user()->id;
      $data_aps = json_decode($aps);
      $data_firewalls = json_decode($firewalls);
      $data_switches = json_decode($switches);

      $dataEquipos = array_merge($data_aps, $data_firewalls, $data_switches);
      $collection = collect($dataEquipos);
      // Filtrando datos sin modelo y cantidad
      $dataEquipos = $collection->whereNotIn('id', 0)
                                ->whereNotIn('cant', 0)->whereNotIn('cant', "");;

      $tablaEquipoActivo = 'equipo_activo_temp' . $id_user;

      if (!Schema::hasTable($tablaEquipoActivo)) {
          Schema::create($tablaEquipoActivo, function (Blueprint $table) use ($tablaEquipoActivo) {
              $table->integer('id');
              $table->integer('cantidad');
              $table->timestamps();
          });
      }

      foreach ($dataEquipos as $data)
      {
        DB::table($tablaEquipoActivo)->insert(
            ['id' => $data->id, 'cantidad' => $data->cant]
        );
      }

    }

    public function getProductsCart($aps ,$firewalls, $switches, $gabinetes)
    {
       $id_user = Auth::user()->id;

       $this->createTableTempProducts($aps ,$firewalls, $switches, $gabinetes);

          try{
            $products = DB::select('CALL px_products_table_products_tmp(?)', array($id_user));
            

            return $products;

          }catch(\Illuminate\Database\QueryException $e){
            Schema::dropIfExists('products_temp' . $id_user);
            return $e;
          }

    }

    public function createTableTempProducts($aps ,$firewalls, $switches, $gabinetes)
    {
      $id_user = Auth::user()->id;
      $data_aps = json_decode($aps);
      $data_firewalls = json_decode($firewalls);
      $data_switches = json_decode($switches);
      $data_gabinetes = json_decode($gabinetes);

      $dataEquipos = array_merge($data_aps, $data_firewalls, $data_switches, $data_gabinetes);
      $collection = collect($dataEquipos);
      // Filtrando datos sin modelo y cantidad
      $dataEquipos = $collection->whereNotIn('id', 0)
                                ->whereNotIn('cant', 0)->whereNotIn('cant', "");;

      $tablaEquipoActivo = 'products_temp' . $id_user;

      if (!Schema::hasTable($tablaEquipoActivo)) {
          Schema::create($tablaEquipoActivo, function (Blueprint $table) use ($tablaEquipoActivo) {
              $table->integer('id');
              $table->integer('cantidad');
              $table->timestamps();
          });
      }

      foreach ($dataEquipos as $data)
      {
        DB::table($tablaEquipoActivo)->insert(
            ['id' => $data->id, 'cantidad' => $data->cant]
        );
      }
    }

    public function getCategories($category, $material, $type, $medida)
    {
      /* Si llega vacio y la categoria es diferente de 
        tuberia se asignan las variables a 0 para saltar ese filtro */
      $material = (empty($material) || $category != 12) ? 0 : $material;
      $type = (empty($type) || $category != 12) ? 0 : $type;
      $medida = (empty($medida) || $category != 12) ? 0 : $medida;

      $products = DB::select('CALL px_products_xcategoria(?,?,?,?)', array($category, $material, $type, $medida));
      $products_categories =  $this->paginate($products, $perPage = 4,  null , $options = []);

      return view('permitted.documentp.products_categories', ['products_categories' => $products_categories])->render();
    }

    public function getCategoriesDescription($category, $description, $material, $type, $medida)
    {
      
      /* Si llega vacio y la categoria es diferente de 
        tuberia se asignan las variables a 0 para saltar ese filtro */
      $material = (empty($material) || $category != 12) ? 0 : $material;
      $type = (empty($type) || $category != 12) ? 0 : $type;
      $medida = (empty($medida) || $category != 12) ? 0 : $medida;
      
      if($category != 0){
        $products = DB::select('CALL px_products_xcategoria_ydescripcion(?,?,?,?,?)', array($category, $description, $material, $type, $medida));
        $products_categories =  $this->paginate($products, $perPage = 4,  null , $options = []);
        
        return view('permitted.documentp.products_categories', ['products_categories' => $products_categories])->render();
      
      }else if($description){
        $products = DB::select('CALL px_products_xdescripcion(?)', array($description));
        $products_categories =  $this->paginate($products, $perPage = 4,  null , $options = []);
        
        return view('permitted.documentp.products_categories', ['products_categories' => $products_categories])->render();
      }

    }

    public function getTypeMaterial($id)
    {
      $types_material = DB::table('product_type_material')->select('id', 'name')->where('product_material_id', $id)->get();
      
      return $types_material;
    }

    public function getProductsByIds(Request $request)
    {
      $products = DB::select('CALL px_products_xcategoria_ydescripcion(?,?,?,?,?)', array($products));
    }

    function paginate($items, $perPage, $page , $options = [])
    {
      $page = $page ?: (Paginator::resolveCurrentPage() ?: 1);
      $items = $items instanceof Collection ? $items : Collection::make($items);

      return new LengthAwarePaginator($items->forPage($page, $perPage), $items->count(), $perPage, $page, ['path'=>url('documentp_cart')]);
	  }
	
    public function deleteProductsShoppingCart(Request $request)
    { 
      $data = json_decode($request->data);
      $documentp = Documentp::findOrFail($data->id_doc);
      $delete_rows = In_Documentp_cart::where('documentp_cart_id', '=', $documentp->documentp_cart_id)->pluck('id');
      $result = In_Documentp_cart::destroy($delete_rows);
      return $result;
    }


}

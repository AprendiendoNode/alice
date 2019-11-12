<?php

namespace App\Http\Controllers\Catalogs;
use DB;
use Auth;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Crypt;
class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      $currency = DB::select('CALL GetAllCurrencyActivev2 ()', array());
      $unitmeasures = DB::select('CALL GetUnitMeasuresActivev2 ()', array());
      $satproduct = DB::select('CALL GetSatProductActivev2 ()', array());
      $satproduct = DB::select('CALL GetSatProductActivev2 ()', array());
      $customer = DB::select('CALL GetCustomersActivev2 ()', array());
      $category = DB::select('CALL GetAllCategoriesActivev2 ()', array());
      $brands = DB::select('CALL GetAllBrandsActivev2 ()', array());
      $models = DB::select('CALL GetAllModelsActivev2 ()', array());
      $estatus = DB::select('CALL GetAllStatusProductsActivev2 ()', array());
      $marcas = DB::select('CALL GetAllBrandsActivev2 ()', array());
      $country = DB::select('CALL GetAllCountryActivev2 ()', array());
      $materiales = DB::table('product_material')->select('id', 'name')->get();
      $material_type = DB::table('product_type_material')->select('id', 'name')->get();
      $unidades = DB::table('product_measure')->select('id', 'unit')->get();
      $list_moneda = DB::table('currencies')->select('name')->pluck('name')->all();
      $list_marca = DB::table('marcas')->select('Nombre_marca')->pluck('Nombre_marca')->all();
      $list_espec = DB::table('especificacions')->select('name')->where([['status', '=', 1],])->pluck('name')->all();
      $especificacion = DB::select('CALL GetAllEspecificacionActivev2 ()', array());

      return view('permitted.catalogs.products',compact('currency','unitmeasures','satproduct', 'customer', 'category','brands','models',
      'estatus', 'marcas', 'especificacion', 'marcas', 'list_moneda', 'list_marca', 'list_espec', 'country', 'materiales', 'unidades', 'material_type'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
          $user_id= Auth::user()->id;
          $key = $request->inputCreatkey;

          $result = DB::table('products')
                    ->select('code')
                    ->where([
                        ['code', '=', $key],
                      ])->count();
          if($result == 0)
          {
            $nkey = $request->inputCreatpart;
            $name = $request->inputCreatname;
            $precio_comas = $request->inputCreatcoindefault;
            $precio_sincomas = str_replace(',','',$precio_comas);

            $nDescription= !empty($request->description) ? $request->description : '';
            $nComment= !empty($request->comment) ? $request->comment : '';

            $id_moneda = $request->sel_modal_coin;
            $id_proveedor = $request->sel_modal_proveedor;
            $id_categoria = $request->sel_categoria;
            $id_modelo = $request->sel_modelo;

            $id_unit = $request->sel_unit;
            $id_satserv = $request->sel_satserv;
            $id_estatus = $request->sel_estatus;

            $orden= $request->inputCreatOrden;
            $fabricante= !empty($request->inputCreatManufacter) ? $request->inputCreatManufacter : '';
            $status= !empty($request->status) ? 1 : 0;

            $id_name_category = DB::select('CALL px_products_categories_name (?)', array($id_categoria));
            $name_category = $id_name_category[0]->categoria;

            $id_name_modelos = DB::select('CALL px_products_modelos_namev2 (?)', array($id_modelo));
            $name_modelos = $id_name_modelos[0]->modelos;

            $rest_id_marca = DB::select('CALL px_products_id_modelosv2 (?)', array($id_modelo));
            $id_marca = $rest_id_marca[0]->marca_id;

            //$rest_id_especification = DB::select('CALL px_products_especification_idv2 (?)', array($id_modelo));
            $id_especification = $request->sel_especification;

            $file_img = $request->file('fileInput');
            $file_extension = $file_img->getClientOriginalExtension(); //** get filename extension
            $fileName = uniqid().'.'.$file_extension;
            $img= $request->file('fileInput')->storeAs('product',$fileName);

            $product_material_id = isset($request->sel_material) ? $request->sel_material : null;
            $product_type_material_id = isset($request->sel_type) ? $request->sel_type : null;
            $product_measure_id = isset($request->sel_unit) ? $request->sel_unit : null;

            $newId = DB::table('products')
            ->insertGetId([
              'name' => $name,
              'code' => $key,
              'num_parte' => $nkey,
              'description' => $nDescription,
              'discount' => $request->discount,
              'image' => $img,
              'model' => $name_modelos,
              'manufacturer' => $fabricante,
              'price' => $precio_sincomas,
              'categoria_id' => $id_categoria,
              'currency_id' => $id_moneda,
              'modelo_id' => $id_modelo,
              'marca_id' => $id_marca,
              'proveedor_id' => $id_proveedor,
              'status_id' => $id_estatus,
              'unit_measure_id' => $id_unit,
              'sat_product_id' => $id_satserv,
              'especifications_id' => $id_especification,
              'comment' => $nComment,
              'product_material_id' => $product_material_id,
              'product_type_material_id' => $product_type_material_id,
              'product_measure_id' => $product_measure_id,
              'sort_order' => $orden,
              'status' => $status,
              'created_uid' => $user_id,
              'created_at' => \Carbon\Carbon::now()
            ]);

            if(empty($newId)) {
              return 'abort'; // returns 0
            }
            else {
              return $newId; // returns id
            }
          }
          else
          {
            return 'false';//Ya esta asociado
          }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
      $user_id= Auth::user()->id;
      $id_prod= $request->fsd;
      $identificador_a= $request->_token_c;

      $key= $request->inputEditkey;
      $nkey= $request->inputEditpart;
      $name= $request->inputEditname;
      $description= $request->inputEditdescription;
      $nComment= !empty($request->inputEditcomment) ? $request->inputEditcomment : '';

      $id_moneda= $request->editsel_modal_coin;
      $id_proveedor= $request->editsel_modal_proveedor;
      $id_categoria= $request->edit_sel_categoria;
      $id_modelo= $request->edit_sel_modelo;
      $id_estatus= $request->edit_sel_estatus;

      $id_unit= $request->edit_sel_unit;
      $id_satserv= $request->edit_sel_satserv;
      $id_manufacter= !empty($request->inputEditManufacter) ? $request->inputEditManufacter : '';

      $precio_comas = $request->inputEditcoindefault;
      $precio_sincomas = str_replace(',','',$precio_comas);

      $orden= $request->inputEditOrden;
      $status= !empty($request->editstatus) ? 1 : 0;

      $id_name_modelito = DB::select('CALL px_products_modelos_namev2 (?)', array($id_modelo));
      $name_modelo = $id_name_modelito[0]->modelos;

      //$rest_id_especification = DB::select('CALL px_products_especification_idv2 (?)', array($id_modelo));
      $id_especification = $request->sel_especification_edit;

      $rest_id_marca = DB::select('CALL px_products_id_modelosv2 (?)', array($id_modelo));
      $id_marca = $rest_id_marca[0]->marca_id;

      $file_img = $request->file('editfileInput');
      if($file_img){
        $id_prox= DB::select('CALL px_products_img (?)', array($id_prod));
        $image_path = 'images/storage/'.$id_prox[0]->img;
        if(File::exists($image_path)) {
          File::delete($image_path);
        }
        $id_name_category = DB::select('CALL px_products_categories_name (?)', array($id_categoria));
        $name_category = $id_name_category[0]->categoria;

        $file_extension = $file_img->getClientOriginalExtension(); // get filename extension
        $fileName = uniqid().'.'.$file_extension;
        $img= $request->file('editfileInput')->storeAs('product/',$fileName);

        DB::table('products')->where('id', $id_prod)->update(['image' => $img]);
      }

      $product_material_id = isset($request->edit_sel_material) ? $request->edit_sel_material : null;
      $product_type_material_id = isset($request->edit_sel_type) ? $request->edit_sel_type : null;
      $product_measure_id = isset($request->edit_sel_unit_product) ? $request->edit_sel_unit_product : null;


      $newId = DB::table('products')
      ->where('id', '=',$id_prod )
      ->update([
                'name' => $name,
                'code' => $key,
                'num_parte' => $nkey,
                'description' => $description,
                'discount' => $request->edit_discount,
                'model' => $name_modelo,
                'manufacturer' => $id_manufacter,
                'price' => $precio_sincomas,
                'categoria_id' => $id_categoria,
                'currency_id' => $id_moneda,
                'modelo_id' => $id_modelo,
                'marca_id' => $id_marca,
                'proveedor_id' => $id_proveedor,
                'status_id' => $id_estatus,
                'unit_measure_id' => $id_unit,
                'sat_product_id' => $id_satserv,
                'especifications_id' => $id_especification,
                'comment' => $nComment,
                'product_material_id' => $product_material_id,
                'product_type_material_id' => $product_type_material_id,
                'product_measure_id' => $product_measure_id,
                'sort_order' => $orden,
                'status' => $status,
                'updated_uid' => $user_id,
                'updated_at' => \Carbon\Carbon::now()]);
      if($newId == '0' ){
          return 'abort'; // returns 0
      }
      else{
          return $newId; // returns id
      }

    }

    public function createStatus(Request $request)
    {
      DB::table('products_status')->insert(
          ['name' => $request->inputCreatName,
            'sort_order' => $request->inputCreatOrden,
            'status' => $request->status]
      );

      return 'true';

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
      $resultados = DB::select('CALL GetAllProductsv2 ()', array());
      return json_encode($resultados);
    }

    public function showEstatusProduct(Request $request)
    {
      $estatus = DB::select('CALL GetAllStatusProductsActivev2 ()', array());
      return json_encode($estatus);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request)
    {
      $identificador= $request->value;
      $resultados = DB::select('CALL GetAllProductsByIdv2 (?)', array($identificador));
      foreach ($resultados as $key) {
        $key->id = Crypt::encryptString($key->id);
      }
      return $resultados;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}

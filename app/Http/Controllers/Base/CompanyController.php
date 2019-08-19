<?php

namespace App\Http\Controllers\Base;
use DB;
use Auth;
use File;
use Illuminate\Support\Facades\Storage;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Helpers\Helper;

use App\Models\Base\Company;
use App\Models\Base\CompanyBankAccount;
use App\Models\Catalogs\Bank;
use App\Models\Catalogs\Country;
use App\Models\Catalogs\Currency;
use App\Models\Catalogs\TaxRegimen;

use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Str;
use Symfony\Component\Process\Exception\ProcessFailedException;
use Symfony\Component\Process\Process;
class CompanyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      $banks = DB::select('CALL GetAllBankActive ()', array());
      $currencies = DB::select('CALL GetAllCurrencyActivev2 ()', array());
      $pacs = DB::select('CALL GetAllPacsActivev2 ()', array());
      $taxregimen = DB::select('CALL GetTaxRegimenActivev2 ()', array());

      $countries = DB::select('CALL GetAllCountryActivev2 ()', array());
      $states = DB::select('CALL GetAllStateActivev2 ()', array());
      $cities = DB::select('CALL GetAllCitiesv2 ()', array());

      $company = DB::select('CALL GetAllCompanyActivev2 ()', array());
      $company_account = DB::select('CALL GetAllAccountCompanyActivev2 ()', array());


      $cfdi = DB::select('CALL GetCfdiActivev2 ()', array());
      $pacs2 = DB::select('CALL GetPacsActivev2 ()', array());
      $question_a = DB::table('companies')->select('name')->where([['id', '=', '1'],])->count();

      return view('permitted.base.companies',compact('countries', 'states', 'cities',
      'banks','currencies', 'pacs', 'taxregimen', 'company', 'cfdi', 'pacs2', 'company_account', 'question_a'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $user_id = Auth::user()->id;
      $creatName = $request->inputCreatName;
       $creatRFC = $request->inputCreatRFC;
     $creatEmail = $request->inputCreatEmail;
     $creatPhone = !empty($request->inputCreatPhone) ? $request->inputCreatPhone : '';
    $creatMobile = !empty($request->inputCreatMobile) ? $request->inputCreatMobile : '';

  $taxregimen_id = $request->select_seven;
         $status = !empty($request->status) ? 1 : 0;
        $comment = !empty($request->datainfo) ? $request->datainfo : '';

      $direccion = $request->inputCreatAddress_1;
         $numExt = !empty($request->inputCreatAddress_2) ? $request->inputCreatAddress_2 : '';
         $numInt = !empty($request->inputCreatAddress_3) ? $request->inputCreatAddress_3 : '';
        $colonia = !empty($request->inputCreatAddress_4) ? $request->inputCreatAddress_4 : '';

      $localidad = !empty($request->inputCreatAddress_5) ? $request->inputCreatAddress_5 : '';
     $referencia = !empty($request->inputCreatAddress_6) ? $request->inputCreatAddress_6 : '';

   $countries_id = $request->select_six;
      $states_id = $request->select_eight;
      $cities_id = $request->select_nine;

      $creatPostcode = $request->inputPostcode;
      $creat_date_start = $request->date_start;
      $creat_date_end = $request->date_end;


      $file_cer_new = '';
      $file_certificate_number = '';
      $file_data_start = '';
      $file_data_end = '';

      $file_key_new = '';
      $file_pass_key = '';
      $file_pfx_new = '';

        //Inserto
        //--------------------------------------------------------------------------------
        $file_img = $request->file('fileInput');
        $file_name = $file_img->getClientOriginalName(); //** get name extension
        $file_extension = $file_img->getClientOriginalExtension(); //** get filename extension
        $fileName = 'logo.'.$file_extension;
        $img= $request->file('fileInput')->storeAs($creatRFC.'/files/companies',$fileName); //Dado que la carpeta sera la rfc de compania
        // $img= $request->file('fileInput')->storeAs('default/files/companies',$fileName);

        //Archivos SAT
        //Convertir en CER a PEM
        $path_file_cer_pem = '';
        if ($request->hasFile('file_file_cer')) {
            $tmp = $this->convertCerToPem(); //
            $file_cer_new = !empty($tmp['file_cer']) ? $tmp['file_cer'] : null;
            $file_certificate_number = !empty($tmp['certificate_number']) ? $tmp['certificate_number'] : null;
            $file_data_start = !empty($tmp['date_start']) ? $tmp['date_start'] : null;
            $file_data_end = !empty($tmp['date_end']) ? $tmp['date_end'] : null;
            $path_file_cer_pem = !empty($tmp['path_file_cer_pem']) ? $tmp['path_file_cer_pem'] : null;
        }
        //Convertir en KEY a PEM, debe contener la contraseña
        $path_file_key_pem = '';
        if ($request->hasFile('file_file_key')) {
            $tmp = $this->convertKeyToPem($request->password_key, $path_file_cer_pem);
            $file_pass_key = !empty($tmp['password_key']) ? $tmp['password_key'] : null;
            $file_key_new = !empty($tmp['file_key']) ? $tmp['file_key'] : null;
            $path_file_key_pem = !empty($tmp['path_file_key_pem']) ? $tmp['path_file_key_pem'] : null;
        }
        //Crear archivo PFX
        if (!empty($path_file_cer_pem) && !empty($path_file_key_pem)) {
            $tmp = $this->createPfx($path_file_key_pem, $request->password_key, $path_file_cer_pem);
            $file_pfx_new = !empty($tmp['file_pfx']) ? $tmp['file_pfx'] : null;
        }
        //Inserto
        $newId = DB::table('companies')
        ->insertGetId([
                   'id' => 1,
                   'name' => $creatName,
                  'image' => $img,
                  'taxid' => $creatRFC,
         'tax_regimen_id' => $taxregimen_id,
                  'email' => $creatEmail,
                  'phone' => $creatPhone,
           'phone_mobile' => $creatMobile,
              'address_1' => $direccion, //Direccion
              'address_2' => $numExt,    //Num. Ext
              'address_3' => $numInt, //Num Int.
              'address_4' => $colonia, //Colonia
              'address_5' => $localidad, //Localidad
              'address_6' => $referencia, //Referencia
                'city_id' => $cities_id,
               'state_id' => $states_id,
             'country_id' => $countries_id,
               'postcode' => $creatPostcode,
               'file_cer' => $file_cer_new,
               'file_key' => $file_key_new,
              'password_key' => $file_pass_key,
              'file_pfx' => $file_pfx_new,
              'certificate_number' => $file_certificate_number,
              'date_start' => $file_data_start,
              'date_end' => $file_data_end,
              'comment' => $comment,
              'sort_order' => '1',
              'status' => $status,
              'created_uid' => $user_id,
              'created_at' => \Carbon\Carbon::now()
        ]);
        if(empty($newId)) {
          return 'abort'; // returns 0
        }
        else {
          //Cuentas bancarias
          //Guarda
          if (!empty($request->item_bank_account)) {
              foreach ($request->item_bank_account as $key => $result) {
                  $newId_account = DB::table('company_bank_accounts')
                  ->insertGetId([
                    'company_id' => $newId,
                    'name' => $result['name'],
                    'account_number' => $result['account_number'],
                    'bank_id' => $result['bank_id'],
                    'currency_id' => $result['currency_id'],
                    'sort_order' => $key,
                    'status' => 1,
                    'created_uid' => $user_id,
                    'created_at' => \Carbon\Carbon::now()
                  ]);
              }
          }
          $newId_account1 =DB::select('CALL px_actualiza_settings (?,?)', array('cfdi_version', $request->select_cfdi));
          $newId_account2 =DB::select('CALL px_actualiza_settings (?,?)', array('default_pac_id', $request->select_pacs));
          return $newId; // returns id
        }
        //--------------------------------------------------------------------------------
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
      $user_id = Auth::user()->id;
    $creatName = $request->inputCreatName;
     $creatRFC = $request->inputCreatRFC;
   $creatEmail = $request->inputCreatEmail;
   $creatPhone = !empty($request->inputCreatPhone) ? $request->inputCreatPhone : '';
  $creatMobile = !empty($request->inputCreatMobile) ? $request->inputCreatMobile : '';

$taxregimen_id = $request->select_seven;
       $status = !empty($request->status) ? 1 : 0;
      $comment = !empty($request->datainfo) ? $request->datainfo : '';

    $direccion = $request->inputCreatAddress_1;
       $numExt = !empty($request->inputCreatAddress_2) ? $request->inputCreatAddress_2 : '';
       $numInt = !empty($request->inputCreatAddress_3) ? $request->inputCreatAddress_3 : '';
      $colonia = !empty($request->inputCreatAddress_4) ? $request->inputCreatAddress_4 : '';

    $localidad = !empty($request->inputCreatAddress_5) ? $request->inputCreatAddress_5 : '';
   $referencia = !empty($request->inputCreatAddress_6) ? $request->inputCreatAddress_6 : '';

    $cities_id = $request->select_nine;
    $states_id = $request->select_eight;
 $countries_id = $request->select_six;

   $creatPostcode = $request->inputPostcode;


   $url_image = DB::table('companies')->where([['id', '=', '1'],])->value('image');

     if ($request->hasFile('fileInput')) {
       Storage::delete($url_image);

       $file_img = $request->file('fileInput');
       $file_name = $file_img->getClientOriginalName(); //** get name extension
       $file_extension = $file_img->getClientOriginalExtension(); //** get filename extension
       $fileName = 'logo.'.$file_extension;

       $img= $request->file('fileInput')->storeAs($creatRFC.'/files/companies',$fileName);
       // $img= $request->file('fileInput')->storeAs('default/files/companies',$fileName);
       $update_img = DB::table('companies')
                 ->where('id', '=', '1')
                 ->update([
                   'image' => $img,
                   'updated_uid' => $user_id,
                   'updated_at' => \Carbon\Carbon::now()
                 ]);
     }

     $file_cer_new = '';
     $file_certificate_number = '';
     $file_data_start = '';
     $file_data_end = '';

     $file_key_new = '';
     $file_pass_key = '';
     $file_pfx_new = '';

     //Archivos SAT
     //Convertir en CER a PEM
     $path_file_cer_pem = '';
     if ($request->hasFile('file_file_cer')) {
         $tmp = $this->convertCerToPem(); //
         $file_cer_new = !empty($tmp['file_cer']) ? $tmp['file_cer'] : null;
         $file_certificate_number = !empty($tmp['certificate_number']) ? $tmp['certificate_number'] : null;
         $file_data_start = !empty($tmp['date_start']) ? $tmp['date_start'] : null;
         $file_data_end = !empty($tmp['date_end']) ? $tmp['date_end'] : null;
         $path_file_cer_pem = !empty($tmp['path_file_cer_pem']) ? $tmp['path_file_cer_pem'] : null;
         $update_cer = DB::table('companies')
                   ->where('id', '=', '1')
                   ->update([
                     'file_cer' => $file_cer_new,
                     'certificate_number' => $file_certificate_number,
                     'date_start' => $file_data_start,
                     'date_end' => $file_data_end,
                     'updated_uid' => $user_id,
                     'updated_at' => \Carbon\Carbon::now()
                   ]);
     }
     //Convertir en KEY a PEM, debe contener la contraseña
     $path_file_key_pem = '';
     if ($request->hasFile('file_file_key')) {
         $tmp = $this->convertKeyToPem($request->password_key, $path_file_cer_pem); //
         $file_pass_key = !empty($tmp['password_key']) ? $tmp['password_key'] : null;
         $file_key_new = !empty($tmp['file_key']) ? $tmp['file_key'] : null;
         $path_file_key_pem = !empty($tmp['path_file_key_pem']) ? $tmp['path_file_key_pem'] : null;

         $update_key = DB::table('companies')
                   ->where('id', '=', '1')
                   ->update([
                     'password_key' => $file_pass_key,
                     'file_key' => $file_key_new,
                     'updated_uid' => $user_id,
                     'updated_at' => \Carbon\Carbon::now()
                   ]);
     }
     //Crear archivo PFX
     if (!empty($path_file_cer_pem) && !empty($path_file_key_pem)) {
         $tmp = $this->createPfx($path_file_key_pem, $request->password_key, $path_file_cer_pem); //
         $file_pfx_new = !empty($tmp['file_pfx']) ? $tmp['file_pfx'] : null;
         $update_pfx = DB::table('companies')
                   ->where('id', '=', '1')
                   ->update([
                     'file_pfx' => $file_pfx_new,
                     'updated_uid' => $user_id,
                     'updated_at' => \Carbon\Carbon::now()
                   ]);
     }
     //Cuentas bancarias
     //Elimina
     if (!empty($request->delete_item_bank_account)) {
         foreach ($request->delete_item_bank_account as $key => $result) {
             //Actualizar status
            DB::table('company_bank_accounts')
            ->where('id', '=', $result)
            ->update([
              'status' => 0,
              'updated_uid' => $user_id,
              'updated_at' => \Carbon\Carbon::now()
            ]);
         }
     }
     //Guarda
     if (!empty($request->item_bank_account)) {
        foreach ($request->item_bank_account as $key => $result) {
          //Valida si es registro nuevo o actualizacion
          if (!empty($result['id'])) {
            DB::table('company_bank_accounts')
            ->where('id', '=', $result['id'])
            ->update([
              'name' => $result['name'],
              'account_number' => $result['account_number'],
              'bank_id' => $result['bank_id'],
              'currency_id' => $result['currency_id'],
              'sort_order' => $key,
              'status' => 1,
              'updated_uid' => $user_id,
              'updated_at' => \Carbon\Carbon::now()
            ]);
          }
          else {
              $newId_account = DB::table('company_bank_accounts')
              ->insertGetId([
                'company_id' => 1,
                'name' => $result['name'],
                'account_number' => $result['account_number'],
                'bank_id' => $result['bank_id'],
                'currency_id' => $result['currency_id'],
                'sort_order' => $key,
                'status' => 1,
                'created_uid' => $user_id,
                'created_at' => \Carbon\Carbon::now()
              ]);
          }
        }
     }
     ////////////////////////////////////////////
     $update_img = DB::table('companies')
               ->where('id', '=', '1')
               ->update([
                     'name' => $creatName,
                    'taxid' => $creatRFC,
           'tax_regimen_id' => $taxregimen_id,
                    'email' => $creatEmail,
                    'phone' => $creatPhone,
             'phone_mobile' => $creatMobile,
                'address_1' => $direccion, //Direccion
                'address_2' => $numExt,    //Num. Ext
                'address_3' => $numInt, //Num Int.
                'address_4' => $colonia, //Colonia
                'address_5' => $localidad, //Localidad
                'address_6' => $referencia, //Referencia
                  'city_id' => $cities_id,
                 'state_id' => $states_id,
               'country_id' => $countries_id,
                 'postcode' => $creatPostcode,
                  'comment' => $comment,
               'sort_order' => '1',
                   'status' => $status,
              'updated_uid' => $user_id,
               'updated_at' => \Carbon\Carbon::now()
               ]);
     return $update_img;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
    /**
     * Funcion para convertir cer a pem y obtener la informacion
     *
     * @return array
     */
    private function convertCerToPem()
    {
        $data = [];
        $name_file_cer = Str::random(40) . '.' . request()->file('file_file_cer')->getClientOriginalExtension();
        $path_file_cer = request()->file('file_file_cer')->storeAs(Helper::setDirectory(Company::PATH_FILES), $name_file_cer); //ruta temporal del archivo
        if (\Storage::exists($path_file_cer)) {
            //Convertir en PEM
            $path_file_cer_pem = $path_file_cer . '.pem';
            $process = new Process('openssl x509 -inform DER -in ' . \Storage::path($path_file_cer) . ' -outform PEM -pubkey -out ' . \Storage::path($path_file_cer_pem));
            $process->run();
            if (!$process->isSuccessful()) {
                throw new ProcessFailedException($process);
            }
            //Genera informacion
            if (\Storage::exists($path_file_cer_pem)) {
                $tmp = openssl_x509_parse(\Storage::get($path_file_cer_pem));
                $data = [
                    'file_cer' => $name_file_cer . '.pem',
                    'certificate_number' => Helper::certificateNumber($tmp['serialNumber']),
                    'date_start' => date('Y-m-d H:i:s', $tmp['validFrom_time_t']),
                    'date_end' => date('Y-m-d H:i:s', $tmp['validTo_time_t']),
                    'path_file_cer_pem' => $path_file_cer_pem,
                ];
            }
            //Eliminar archivo .cer
            //\Storage::delete(Company::PATH_FILES . '/' . $name_file_cer);
        }
        return $data;
    }
    /**
     * Funcion para convertir cer a pem y obtener la informacion
     *
     * @param $request
     * @param $path_file_cer_pem
     * @return array
     * @throws \Exception
     */
    private function convertKeyToPem($password_key, $path_file_cer_pem)
    {
        $data = [];
        $name_file_key = Str::random(40) . '.' . request()->file('file_file_key')->getClientOriginalExtension();
        $path_file_key = request()->file('file_file_key')->storeAs(Helper::setDirectory(Company::PATH_FILES), $name_file_key);
        if (\Storage::exists($path_file_key)) {
            //Convertir en PEM
            $path_file_key_pem = $path_file_key . '.pem';
            $process = new Process('openssl pkcs8 -inform DER -in ' . \Storage::path($path_file_key) . ' -passin pass:' . $password_key . ' -outform PEM -out ' . \Storage::path($path_file_key_pem));
            $process->run();
            if (!$process->isSuccessful()) {
                throw new ProcessFailedException($process);
            }
            //Convertir en PEM con contraseña
            $path_file_key_pass_pem = $path_file_key . '.pass.pem';
            //$process           = new Process('openssl pkcs8 -inform DER -in ' . $path_file_key . ' -passin pass:' . $request->password_key . ' -outform PEM -out ' . $path_file_key_pass_pem .' -passout pass:' . $request->password_key);
            $process = new Process('openssl rsa -in ' . \Storage::path($path_file_key_pem) . ' -des3 -out ' . \Storage::path($path_file_key_pass_pem) . ' -passout pass:' . $password_key);
            $process->run();
            if (!$process->isSuccessful()) {
                throw new ProcessFailedException($process);
            }
            //Valida que la llave privada este correcta con su contraseña
            $this->validateKeyPem($path_file_key_pass_pem, $password_key);
            //Valida que la llave privada pertenezca al certificado
            $this->validateKeyBelongToCer($path_file_key_pass_pem, $password_key, $path_file_cer_pem);
            //Genera informacion
            $data = [
                'password_key' => Crypt::encryptString($password_key),
                'file_key' => $name_file_key . '.pass.pem',
                'path_file_key_pem' => $path_file_key_pem,
            ];
            //Eliminar archivo
            //\Storage::delete(Company::PATH_FILES . '/' . $name_file_key);
        }
        return $data;
    }
    /**
     * Crea archivo pfx
     *
     * @param $path_file_key_pass_pem
     * @param $password_key
     * @param $path_file_cer_pem
     * @return bool
     * @throws \Exception
     */
    public function createPfx($path_file_key_pem, $password_key, $path_file_cer_pem)
    {
        $data = [];
        if (\Storage::exists($path_file_key_pem) && \Storage::exists($path_file_cer_pem)) {
            $name_file_pfx = Str::random(40) . '.pfx';
            $path_file_pfx = Helper::setDirectory(Company::PATH_FILES). '/' . $name_file_pfx;
            //Crear archivo PFX
            $process = new Process('openssl pkcs12 -export -inkey ' . \Storage::path($path_file_key_pem) . ' -in ' . \Storage::path($path_file_cer_pem) . ' -out ' . \Storage::path($path_file_pfx) . ' -passout pass:' . $password_key);
            $process->run();
            if (!$process->isSuccessful()) {
                throw new ProcessFailedException($process);
            }
            //Genera informacion
            $data = [
                'file_pfx' => $name_file_pfx,
            ];
        }
        return $data;
    }

    /**
     * Valida que la contraseña este correcta con la llave en formato PEM
     *
     * @param $path_file_key_pass_pem
     * @param $password_key
     * @return bool
     * @throws \Exception
     */
    public function validateKeyPem($path_file_key_pass_pem, $password_key)
    {
        if (\Storage::exists($path_file_key_pass_pem)) {
            $pkeyid = openssl_pkey_get_private(\Storage::get($path_file_key_pass_pem), $password_key);
            if ($pkeyid == false) {
                throw new \Exception('La contraseña no corresponde a la llave privada');
            } else {
                openssl_free_key($pkeyid);
                return true;
            }
        }
    }
    /**
     * Valida que que el archivo cer pertenezca al archivo key
     *
     * @param $path_file_key_pass_pem
     * @param $password_key
     * @param $path_file_cer_pem
     * @return bool
     * @throws \Exception
     */
    public function validateKeyBelongToCer($path_file_key_pass_pem, $password_key, $path_file_cer_pem)
    {
        if (\Storage::exists($path_file_key_pass_pem) && \Storage::exists($path_file_cer_pem)) {
            $text_test = 'Test CFDI 3.3';
            $pkeyid = openssl_pkey_get_private(\Storage::get($path_file_key_pass_pem), $password_key);
            $pubkeyid = openssl_pkey_get_public(\Storage::get($path_file_cer_pem));
            openssl_sign($text_test, $crypttext, $pkeyid, OPENSSL_ALGO_SHA256);
            $ok = openssl_verify($text_test, $crypttext, $pubkeyid, OPENSSL_ALGO_SHA256);
            openssl_free_key($pkeyid);
            if ($ok == 1) {
                return true;
            } else {
                throw new \Exception('El certificado no corresponde a la llave privada');
            }
        }
    }
}

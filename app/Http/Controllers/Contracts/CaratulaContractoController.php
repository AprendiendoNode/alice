<?php

namespace App\Http\Controllers\Contracts;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Storage;
use \Carbon\Carbon;
use DB;
use Auth;
use PDF;
use Illuminate\Support\Collection as Collection;
class CaratulaContractoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      return view('permitted.contract.caratula_contrato');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
      $user_id = Auth::id();
      $RazonSocial = $request->InputRazonSocial;
      $Representante = $request->InputRepresentante;
      $TelefonoContacto = $request->InputTelefonoContacto;
      $CorreoContacto = $request->InputCorreoContacto;

      $Rfc = $request->InputRfc;
      $Cfdi = $request->InputCfdi;
      $Direccion = $request->InputDireccion;
      $MetodoPago = $request->InputMetodoPago;

      $DireccionPersona = $request->InputDireccionPersona;
      $AtencionPersona = $request->InputAtencionPersona;

      $Especificaciones = !empty($request->textareaEspecificaciones) ? $request->textareaEspecificaciones : '';

      $Vigencia = $request->InputVigencia;
      $DiasPago = $request->InputDiasPago;
      $MonedaPago = $request->InputMonedaPago;

      $CondicionesEspeciales = !empty($request->textareaCondicionesEspeciales) ? $request->textareaCondicionesEspeciales : '';

      $AplicaGarantia = $request->InputAplicaGarantia;
      if ($AplicaGarantia == 0) {
        $AplicaGarantia_Save = '0';
        $NoAplicaGarantia_Save = '';
      }
      if ($AplicaGarantia == 1) {
        $AplicaGarantia_Save = '1';
        $NoAplicaGarantia_Save = '';
      }
      $MontoPago = $request->InputMontoPago;
      // $MontoGarantia = $request->InputMontoGarantia;
      $MontoGarantia = !empty($request->InputMontoGarantia) ? $request->InputMontoGarantia : 0;

      $FormatoMontoPago = $MontoPago;
      $FormatoMontoGarantia = $MontoGarantia;

      $SinFormatoMontoPago = str_replace(",", "", $MontoPago);
      $SinFormatoMontoGarantia = str_replace(",", "", $MontoGarantia);

      $Observaciones = !empty($request->textareaObservaciones) ? $request->textareaObservaciones : '';

      $newId = DB::table('caratulacontrato')
               ->insertGetId([
                         'razon_social' => $RazonSocial,
                        'representante' => $Representante,
                    'telefono_contacto' => $TelefonoContacto,
                      'correo_contacto' => $CorreoContacto,
                                  'rfc' => $Rfc,
                                 'cfdi' => $Cfdi,
                            'direccion' => $Direccion,
                          'metodo_pago' => $MetodoPago,
                    'direccion_persona' => $DireccionPersona,
                     'atencion_persona' => $AtencionPersona,
                     'especificaciones' => $Especificaciones,
                             'vigencia' => $Vigencia,
                           'monto_pago' => $SinFormatoMontoPago,
                            'dias_pago' => $DiasPago,

                          'moneda_pago' => $MonedaPago,

               'condiciones_especiales' => $CondicionesEspeciales,

                      'aplica_garantia' => $AplicaGarantia_Save,
                   'no_aplica_garantia' => $NoAplicaGarantia_Save,
                       'monto_garantia' => $SinFormatoMontoGarantia,

                        'observaciones' => $Observaciones,
                          'created_uid' => $user_id,
                           'created_at' => \Carbon\Carbon::now()
               ]);
      $pdf = PDF::loadView('permitted.contract.pdf_caratula_contrato',
      compact(
        'RazonSocial', 'Representante', 'TelefonoContacto', 'CorreoContacto',
        'Rfc', 'Cfdi', 'Direccion', 'MetodoPago',
        'DireccionPersona', 'AtencionPersona',
        'Especificaciones',
        'Vigencia',
        'MontoPago', 'DiasPago', 'MonedaPago',
        'CondicionesEspeciales',
        'AplicaGarantia', 'MontoGarantia',
        'Observaciones',
        'FormatoMontoPago','FormatoMontoGarantia'
      ))->setPaper('letter');
      return $pdf->stream();
    }
    public function view_pdf() {
        $pdf = PDF::loadView('permitted.contract.pdf_caratula_contrato')->setPaper('letter');
        return $pdf->stream();
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show_info(Request $request)
    {
      return view('permitted.contract.ver_caratula_contrato');
    }
    public function search_info(Request $request)
    {
      $resultado = DB::select('CALL GetCaratulas ()', array());
      return json_encode($resultado);
    }
    public function redondeo(Request $request)
    {
        //Variables
        $SinFormatoValorInput = str_replace(",", "", $request->valorInput);
        $items_monto = !empty($SinFormatoValorInput) ? $SinFormatoValorInput : '';
        $json = new \stdClass;
        // $numbertxt = round($items_monto, 4);
        $json->text = number_format($items_monto, 4, '.', ',');
        // $json->text = round($items_monto, 4);
        return response()->json($json);
    }
    public function editar_caratula_contrato(Request $request)
    {
      $identificador= $request->token_b;
      $resultados = DB::select('CALL get_caratulacontrato_id (?)', array($identificador));
      foreach ($resultados as $key) {
        $key->id = Crypt::encryptString($key->id);
        $key->monto_pago = number_format($key->monto_pago, 4, '.', ',');
        $key->monto_garantia = number_format($key->monto_garantia, 4, '.', ',');
      }
      return $resultados;
    }
    public function save_edition_caratula_contrato(Request $request)
    {
      $user_id = Auth::id();
      $id_received= Crypt::decryptString($request->token_b);
      $RazonSocial = $request->InputRazonSocial;
      $Representante = $request->InputRepresentante;
      $TelefonoContacto = $request->InputTelefonoContacto;
      $CorreoContacto = $request->InputCorreoContacto;

      $Rfc = $request->InputRfc;
      $Cfdi = $request->InputCfdi;
      $Direccion = $request->InputDireccion;
      $MetodoPago = $request->InputMetodoPago;

      $DireccionPersona = $request->InputDireccionPersona;
      $AtencionPersona = $request->InputAtencionPersona;

      $Especificaciones = !empty($request->textareaEspecificaciones) ? $request->textareaEspecificaciones : '';

      $Vigencia = $request->InputVigencia;
      $MontoPago = $request->InputMontoPago;
      $DiasPago = $request->InputDiasPago;

      $MonedaPago = $request->InputMonedaPago;

      $CondicionesEspeciales = !empty($request->textareaCondicionesEspeciales) ? $request->textareaCondicionesEspeciales : '';

      $AplicaGarantia = $request->InputAplicaGarantia;
      if ($AplicaGarantia == 0) {
        $AplicaGarantia_Save = '0';
        $NoAplicaGarantia_Save = '';
      }
      if ($AplicaGarantia == 1) {
        $AplicaGarantia_Save = '1';
        $NoAplicaGarantia_Save = '';
      }
      // $MontoGarantia = $request->InputMontoGarantia;
      $MontoGarantia = !empty($request->InputMontoGarantia) ? $request->InputMontoGarantia : 0;

      $SinFormatoMontoPago = str_replace(",", "", $MontoPago);
      $SinFormatoMontoGarantia = str_replace(",", "", $MontoGarantia);

      $Observaciones = !empty($request->textareaObservaciones) ? $request->textareaObservaciones : '';

      $newId = DB::table('caratulacontrato')
          ->where('id', '=', $id_received )
          ->update([
                    'razon_social' => $RazonSocial,
                   'representante' => $Representante,
               'telefono_contacto' => $TelefonoContacto,
                 'correo_contacto' => $CorreoContacto,
                             'rfc' => $Rfc,
                            'cfdi' => $Cfdi,
                       'direccion' => $Direccion,
                     'metodo_pago' => $MetodoPago,
               'direccion_persona' => $DireccionPersona,
                'atencion_persona' => $AtencionPersona,
                'especificaciones' => $Especificaciones,
                        'vigencia' => $Vigencia,
                      'monto_pago' => $SinFormatoMontoPago,
                       'dias_pago' => $DiasPago,

                     'moneda_pago' => $MonedaPago,

          'condiciones_especiales' => $CondicionesEspeciales,

                 'aplica_garantia' => $AplicaGarantia_Save,
              'no_aplica_garantia' => $NoAplicaGarantia_Save,
                  'monto_garantia' => $SinFormatoMontoGarantia,

                   'observaciones' => $Observaciones,
                     'updated_uid' => $user_id,
                     'updated_at' => \Carbon\Carbon::now()
          ]);
      if($newId == '0' ){
        return 'abort'; // returns 0
      }
      else{
        return $newId; // returns id
      }
    }
    public function delete_caratula_contrato(Request $request)
    {
      $user_id= Auth::user()->id;
      $result = DB::table('caratulacontrato')
                  ->where('id', '=', $request->token_d)
                  ->update([
                    'updated_uid' => $user_id,
                    'deleted_at' => \Carbon\Carbon::now()
                  ]);
      return response()->json(['status' => 200]);
    }
    public function download_caratula_contrato(Request $request)
    {
      $identificador= $request->token_ab;
      $resultados = DB::select('CALL get_caratulacontrato_id (?)', array($identificador));

      $RazonSocial = $resultados[0]->razon_social;
      $Representante = $resultados[0]->representante;
      $TelefonoContacto = $resultados[0]->telefono_contacto;
      $CorreoContacto = $resultados[0]->correo_contacto;

      $Rfc = $resultados[0]->rfc;
      $Cfdi = $resultados[0]->cfdi;
      $Direccion = $resultados[0]->direccion;
      $MetodoPago = $resultados[0]->metodo_pago;

      $DireccionPersona = $resultados[0]->direccion_persona;
      $AtencionPersona = $resultados[0]->atencion_persona;

      $Especificaciones = $resultados[0]->especificaciones;
      $Vigencia = $resultados[0]->vigencia;

      $DiasPago = $resultados[0]->dias_pago;
      $MonedaPago = $resultados[0]->moneda_pago;

      $CondicionesEspeciales = $resultados[0]->condiciones_especiales;

      $AplicaGarantia = $resultados[0]->aplica_garantia;
      if ($AplicaGarantia == 0) {
        $AplicaGarantia_Save = '0';
        $NoAplicaGarantia_Save = '';
      }
      if ($AplicaGarantia == 1) {
        $AplicaGarantia_Save = '1';
        $NoAplicaGarantia_Save = '';
      }

      $MontoGarantia = $resultados[0]->monto_garantia;
      $FormatoMontoGarantia = number_format($MontoGarantia, 4, '.', ',');
      $SinFormatoMontoGarantia = str_replace(",", "", $MontoGarantia);

      $MontoPago = $resultados[0]->monto_pago;
      $FormatoMontoPago = number_format($MontoPago, 4, '.', ',');
      $SinFormatoMontoPago = str_replace(",", "", $MontoPago);

      $Observaciones = $resultados[0]->observaciones;

      $pdf = PDF::loadView('permitted.contract.pdf_caratula_contrato',
      compact(
        'RazonSocial', 'Representante', 'TelefonoContacto', 'CorreoContacto',
        'Rfc', 'Cfdi', 'Direccion', 'MetodoPago',
        'DireccionPersona', 'AtencionPersona',
        'Especificaciones',
        'Vigencia',
        'MontoPago', 'DiasPago', 'MonedaPago',
        'CondicionesEspeciales',
        'AplicaGarantia', 'MontoGarantia',
        'Observaciones',
        'FormatoMontoPago', 'FormatoMontoGarantia'
      ))->setPaper('letter');

      // $pdf = PDF::loadView('permitted.contract.pdf_caratula_contrato2')->setPaper('letter');
      return $pdf->stream();
      // return response( $pdf->stream()->header('Content-Type', 'application/octet-stream') );
    }
}

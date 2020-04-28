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
    public function caratula_contrato_blank(Request $request)
    {
      $pdf = PDF::loadView('permitted.contract.pdf_caratula_contrato_blank');
      return $pdf->stream();
    }
    public function store(Request $request)
    {
      $user_id = Auth::id();
      $RazonSocial = $request->InputRazonSocial;
      $Representante = $request->InputRepresentante;
      $TelefonoContacto = $request->InputTelefonoContacto;

      $CorreoContactoCobranza = !empty($request->InputEmailCobranza) ?  $request->InputEmailCobranza  : '';
      $CorreoContactoComercial = !empty($request->InputEmailComercial) ? $request->InputEmailComercial : '';
      $CorreoContactoLegal = !empty($request->InputEmailLegal) ? $request->InputEmailLegal : '';

      $Rfc = $request->InputRfc;
      $Cfdi = $request->InputCfdi;
      $Direccion = $request->InputDireccion;
      $MetodoPago = $request->InputMetodoPago;

      $DireccionPersona = $request->InputDireccionPersona;
      $CorreoPersona = $request->InputEmailCliente;
      $AtencionPersona = $request->InputAtencionPersona;

      $TipoServicio = !empty($request->InputTipoServ) ? $request->InputTipoServ : '';
      $Vigencia = $request->InputVigencia;

      $MontoPago = $request->InputMontoPago;
      $MonedaPago = $request->InputMonedaPago;
      $DosUltMeses = $request->InputDosUltMeses;

      $AplicaGarantia = $request->InputAplicaGarantia;
      $MontoGarantia = !empty($request->InputMontoGarantia) ? $request->InputMontoGarantia : 0;

      $CondicionesEspeciales = !empty($request->textareaCondicionesEspeciales) ? $request->textareaCondicionesEspeciales : '';


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
             'correo_contacto_cobranza' => $CorreoContactoCobranza,
            'correo_contacto_comercial' => $CorreoContactoComercial,
                'correo_contacto_legal' => $CorreoContactoLegal,
                                  'rfc' => $Rfc,
                                 'cfdi' => $Cfdi,
                            'direccion' => $Direccion,
                          'metodo_pago' => $MetodoPago,
                    'direccion_persona' => $DireccionPersona,
                       'correo_cliente' => $CorreoPersona,
                     'atencion_persona' => $AtencionPersona,
                        'tipo_servicio' => $TipoServicio,
                             'vigencia' => $Vigencia,
                           'monto_pago' => $SinFormatoMontoPago,
                          'moneda_pago' => $MonedaPago,

                     'pago_ultms_meses' => $DosUltMeses,
                      'aplica_garantia' => $AplicaGarantia,
                       'monto_garantia' => $SinFormatoMontoGarantia,
               'condiciones_especiales' => $CondicionesEspeciales,
                        'observaciones' => $Observaciones,
                          'created_uid' => $user_id,
                           'created_at' => \Carbon\Carbon::now()
               ]);
      $pdf = PDF::loadView('permitted.contract.pdf_caratula_contrato',
      compact(
        'RazonSocial','Representante','TelefonoContacto','CorreoContactoCobranza','CorreoContactoComercial',
        'CorreoContactoLegal','Rfc','Cfdi','Direccion','MetodoPago','DireccionPersona','CorreoPersona',
        'AtencionPersona','TipoServicio','Vigencia','MonedaPago','DosUltMeses','AplicaGarantia','CondicionesEspeciales',
        'MontoPago','MontoGarantia'
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

      $CorreoContactoCobranza = !empty($request->InputEmailCobranza) ?  $request->InputEmailCobranza  : '';
      $CorreoContactoComercial = !empty($request->InputEmailComercial) ? $request->InputEmailComercial : '';
      $CorreoContactoLegal = !empty($request->InputEmailLegal) ? $request->InputEmailLegal : '';

      $Rfc = $request->InputRfc;
      $Cfdi = $request->InputCfdi;
      $Direccion = $request->InputDireccion;
      $MetodoPago = $request->InputMetodoPago;

      $DireccionPersona = $request->InputDireccionPersona;
      $CorreoPersona = $request->InputEmailCliente;
      $AtencionPersona = $request->InputAtencionPersona;

      $TipoServicio = !empty($request->InputTipoServ) ? $request->InputTipoServ : '';
      $Vigencia = $request->InputVigencia;

      $MontoPago = !empty($request->InputMontoPago) ? $request->InputMontoPago : 0;
      $MonedaPago = $request->InputMonedaPago;
      $DosUltMeses = $request->InputDosUltMeses;

      $AplicaGarantia = $request->InputAplicaGarantia;
      $MontoGarantia = !empty($request->InputMontoGarantia) ? $request->InputMontoGarantia : 0;

      $CondicionesEspeciales = !empty($request->textareaCondicionesEspeciales) ? $request->textareaCondicionesEspeciales : '';
      $Observaciones = !empty($request->textareaObservaciones) ? $request->textareaObservaciones : '';

      $SinFormatoMontoPago = str_replace(",", "", $MontoPago);
      $SinFormatoMontoGarantia = str_replace(",", "", $MontoGarantia);


      $newId = DB::table('caratulacontrato')
          ->where('id', '=', $id_received )
          ->update([
                    'razon_social' => $RazonSocial,
                   'representante' => $Representante,
               'telefono_contacto' => $TelefonoContacto,
        'correo_contacto_cobranza' => $CorreoContactoCobranza,
       'correo_contacto_comercial' => $CorreoContactoComercial,
           'correo_contacto_legal' => $CorreoContactoLegal,
                             'rfc' => $Rfc,
                            'cfdi' => $Cfdi,
                       'direccion' => $Direccion,
                     'metodo_pago' => $MetodoPago,
               'direccion_persona' => $DireccionPersona,
                  'correo_cliente' => $CorreoPersona,
                'atencion_persona' => $AtencionPersona,
                   'tipo_servicio' => $TipoServicio,
                        'vigencia' => $Vigencia,
                      'monto_pago' => $SinFormatoMontoPago,
                     'moneda_pago' => $MonedaPago,
                'pago_ultms_meses' => $DosUltMeses,
                 'aplica_garantia' => $AplicaGarantia,
                  'monto_garantia' => $SinFormatoMontoGarantia,
          'condiciones_especiales' => $CondicionesEspeciales,
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

      $CorreoContactoCobranza = $resultados[0]->correo_contacto_cobranza;
      $CorreoContactoComercial = $resultados[0]->correo_contacto_comercial;
      $CorreoContactoLegal = $resultados[0]->correo_contacto_legal;

      $Rfc = $resultados[0]->rfc;
      $Cfdi = $resultados[0]->cfdi;
      $Direccion = $resultados[0]->direccion;

      $MetodoPago = $resultados[0]->metodo_pago;
      $DireccionPersona = $resultados[0]->direccion_persona;
      $CorreoPersona = $resultados[0]->correo_cliente;
      $AtencionPersona = $resultados[0]->atencion_persona;

      $TipoServicio = $resultados[0]->tipo_servicio;
      $Vigencia = $resultados[0]->vigencia;

      // Aplicar formato
      $SinFormatoMontoPago = $resultados[0]->monto_pago;
      $MontoPago = number_format($SinFormatoMontoPago, 4, '.', ',');

      $MonedaPago = $resultados[0]->moneda_pago;
      $DosUltMeses = $resultados[0]->pago_ultms_meses;

      $AplicaGarantia = $resultados[0]->aplica_garantia;
      //Aplicar formato
      $SinFormatoMontoGarantia = $resultados[0]->monto_garantia;
      $MontoGarantia = number_format($SinFormatoMontoGarantia, 4, '.', ',');

      $CondicionesEspeciales = $resultados[0]->condiciones_especiales;
      $Observaciones = $resultados[0]->observaciones;

      $pdf = PDF::loadView('permitted.contract.pdf_caratula_contrato',
      compact(
        'RazonSocial','Representante','TelefonoContacto','CorreoContactoCobranza','CorreoContactoComercial',
        'CorreoContactoLegal','Rfc','Cfdi','Direccion','MetodoPago','DireccionPersona','CorreoPersona',
        'AtencionPersona','TipoServicio','Vigencia','MonedaPago','DosUltMeses','AplicaGarantia','CondicionesEspeciales', 'Observaciones',
        'MontoPago','MontoGarantia'
      ))->setPaper('letter');

      return $pdf->stream();
    }
}

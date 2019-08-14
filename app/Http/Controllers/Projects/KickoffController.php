<?php

namespace App\Http\Controllers\Projects;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use App\Models\Projects\{Documentp, Documentp_cart, In_Documentp_cart, Cotizador};
use App\Models\Projects\{Kickoff_approvals, Kickoff_compras, Kickoff_contrato, Kickoff_instalaciones, Kickoff_lineabase, Kickoff_perfil_cliente, Kickoff_project, Kickoff_soporte};
use App\Mail\SolicitudCompra;
use App\User;
use View;
use PDF;
use Mail;
use Auth;
use DB;

class KickoffController extends Controller
{
    public function index(Request $request)
    {
      $id = $request->id_doc_3;
      $document = DB::select('CALL px_documentop_data(?)', array($id));

      $documentP = Documentp::find($id);
      $id_document = $documentP->id;

      $in_document_cart = In_Documentp_cart::where('documentp_cart_id', $document[0]->documentp_cart_id)->first();
      $tipo_cambio = $in_document_cart->tipo_cambio;

      $vtc = "Proyecto sin cotizador";
      $cotizador = DB::table('cotizador')->select('id', 'id_doc')->where('id_doc', $document[0]->id)->get();

      if(count($cotizador) == 1) {
        $objetivos = DB::table('cotizador_objetivos')->select()->where('cotizador_id', $cotizador[0]->id)->get();
        $vtc = $objetivos[0]->vtc;
      }
      //KICKOFF DATA
      $kickoff = Kickoff_project::firstOrCreate(['id_doc' => $id_document]);
      $kickoff_approvals = Kickoff_approvals::firstOrCreate(['kickoff_id' => $kickoff->id]);
      $kickoff_compras = Kickoff_compras::firstOrCreate(['kickoff_id' => $kickoff->id]);
      $kickoff_contrato = Kickoff_contrato::firstOrCreate(['kickoff_id' => $kickoff->id]);
      $kickoff_instalaciones = Kickoff_instalaciones::firstOrCreate(['kickoff_id' => $kickoff->id]);
      $kickoff_lineabase = Kickoff_lineabase::firstOrCreate(['kickoff_id' => $kickoff->id]);
      $kickoff_perfil_cliente = Kickoff_perfil_cliente::firstOrCreate(['kickoff_id' => $kickoff->id]);
      $kickoff_soporte = Kickoff_soporte::firstOrCreate(['kickoff_id' => $kickoff->id]);
      //dd($kickoff_contrato);
      return view('permitted.planning.kick_off_edit', compact('document', 'tipo_cambio', 'vtc', 'kickoff_approvals',
                  'kickoff_contrato', 'kickoff_instalaciones', 'kickoff_lineabase', 'kickoff_perfil_cliente', 'kickoff_soporte' ));
    }

    public function update(Request $request)
    {
      $flag  = "false";
      $id = $request->id;

      DB::beginTransaction();
      try {
        $documentp = Documentp::find($id);
        $documentp->num_oportunidad = $request->proyecto;
        $documentp->num_sitios = $request->sitios;
        $documentp->densidad = $request->densidad;
        $documentp->updated_at = \Carbon\Carbon::now();
        $documentp->save();

        //Actualizando métricas del cotizador
        $kickoff = Kickoff_project::where('id_doc', $documentp->id)->first();
        //Inversion
        DB::table('kickoff_perfil_cliente')->where('kickoff_id', $kickoff->id)->update([
           'rfc' => $request->rfc,
           'razon_social' => $request->razon_social,
           'edo_municipio' => $request->edo_municipio,
           'contacto' => $request->contacto,
           'puesto' => $request->puesto,
           'telefono' => $request->telefono,
           'email' => $request->email,
           'direccion' => $request->direccion,
           'updated_at' => \Carbon\Carbon::now()
        ]);

        DB::commit();
        $flag  = "true";

      } catch(\Exception $e){
        $e->getMessage();
        DB::rollback();
        //dd($e);
        return $e;
      }

      return $flag;
    }


}

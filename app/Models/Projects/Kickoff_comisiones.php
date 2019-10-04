<?php

namespace App\Models\Projects;

use Illuminate\Database\Eloquent\Model;
use App\Models\Projects\{Documentp,Cotizador,Cotizador_inversion, Kickoff_project};

class Kickoff_comisiones extends Model
{
    protected $table = 'kickoff_comisiones';
    protected $fillable = ['kickoff_id'];

    public static function calculateCommissionByDefault($id_document)
    {
      $documentp = Documentp::findOrFail($id_document);
      $cotizador = Cotizador::where('id_doc', $documentp->id)->get();
      $cotizador_inversion = Cotizador_inversion::findOrFail(['cotizador_id' => $cotizador[0]->id]);

      $amount_comision = $cotizador_inversion[0]->comision;

      $type_service = $documentp->tipo_servicio_id;

      $contacto_amount = 0.0;
      $contacto_percent = 0;

      $cierre_amount = 0.0;
      $cierre_percent = 0;

      $itconcierge_amount = 0.0;
      $itconcierge_percent = 0;

      $inside_sales_amount = 0.0;
      $inside_sales_percent = 0;

      if($type_service == 1){
         $contacto_percent = 35;
         $cierre_percent = 35;
         $itconcierge_percent = 20;
         $inside_sales_percent = 10;

         $contacto_amount = ($amount_comision * $contacto_percent) / 100;
         $cierre_amount = ($amount_comision * $cierre_percent) / 100;
         $itconcierge_amount = ($amount_comision * $itconcierge_percent) / 100;
         $inside_sales_amount = ($amount_comision * $inside_sales_percent) / 100;
      }else if($type_service == 2 || $type_service == 3) {
        $cierre_percent = 45;
        $itconcierge_percent = 45;
        $inside_sales_percent = 10;

        $cierre_amount = ($amount_comision * $cierre_percent) / 100;
        $itconcierge_amount = ($amount_comision * $itconcierge_percent) / 100;
        $inside_sales_amount = ($amount_comision * $inside_sales_percent) / 100;
      }

      $data = array(
        'amount_itc' => $itconcierge_amount,
        'amount_inside_sales' => $inside_sales_amount,
        'amount_contacto' => $contacto_amount,
        'amount_cierre' => $cierre_amount,
        'percent_itc' => $itconcierge_percent,
        'percent_inside_sales' => $inside_sales_percent,
        'percent_contacto' => $contacto_percent,
        'percent_cierre' => $cierre_percent
      );

      return json_encode($data);

    }

    public static function save_comision_default($request, $data)
    {
      $data = json_decode($data);
      $documentp = Documentp::findOrFail($request->id);
      $kickoff = Kickoff_project::where('id_doc', $documentp->id)->get();
      $kickoff_comisiones = kickoff_comisiones::where('kickoff_id', $kickoff[0]->id)->first();
      $kickoff_comisiones->itconcierge = $request->itconciergecomision;
      $kickoff_comisiones->inside_sales = $request->inside_sales;
      $kickoff_comisiones->contacto = $request->contacto_comercial;
      $kickoff_comisiones->cierre = $request->cierre;
      $kickoff_comisiones->amount_itc = $data->amount_itc;
      $kickoff_comisiones->amount_inside_sales = $data->amount_inside_sales;
      $kickoff_comisiones->amount_contacto = $data->amount_contacto;
      $kickoff_comisiones->amount_cierre = $data->amount_cierre;
      $kickoff_comisiones->amount_vendedor = 0.0;
      $kickoff_comisiones->amount_colaborador = 0.0;
      $kickoff_comisiones->amount_externo1 = 0.0;
      $kickoff_comisiones->amount_externo2 = 0.0;
      $kickoff_comisiones->percent_itc = $data->percent_itc;
      $kickoff_comisiones->percent_inside_sales = $data->percent_inside_sales;
      $kickoff_comisiones->percent_contacto = $data->percent_contacto;
      $kickoff_comisiones->percent_cierre = $data->percent_cierre;
      $kickoff_comisiones->percent_colaborador = 0;
      $kickoff_comisiones->percent_vendedor = 0;
      $kickoff_comisiones->percent_externo1 = 0;
      $kickoff_comisiones->percent_externo2 = 0;
      $kickoff_comisiones->save();
    }




}

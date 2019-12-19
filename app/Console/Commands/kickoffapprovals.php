<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use DB;
use Mail;
use App\Models\Projects\Documentp;
use App\Mail\NewKickoffProject;
use Illuminate\Support\Arr;
use App\Mail\SendEmailSurvey;

class kickoffapprovals extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'kickoff:sendmails';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Envia correo a todos los usuarios que faltan aprobar un proyecto en status "kickoff".';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $data_emails = [];
        $data_insert = [];

        $sql = DB::select('CALL px_users_x_autorizar_kickoff()', array());
        $sql_count = count($sql);
        
        if($sql_count > 0)
        {
            for ($i=0; $i < $sql_count; $i++)
            {
               $emails = array();
               array_push($emails, trim($sql[$i]->itc_email)); 
               array_push($emails, trim($sql[$i]->comercial_email));  
               array_push($emails, trim($sql[$i]->proyectos_email));  
               array_push($emails, trim($sql[$i]->soporte_email));  
               array_push($emails, trim($sql[$i]->planeacion_email));  
               array_push($emails, trim($sql[$i]->legal_email)); 
               array_push($emails, trim($sql[$i]->facturacion_email));
               array_push($emails, trim($sql[$i]->servicio_cliente_email));
               array_push($emails, trim($sql[$i]->investigacion_desarrollo_email));

               $approval_dir = DB::select('CALL px_valida_aprobado_direccion(?)', array($sql[$i]->approvals_id));

               if($approval_dir[0]->aprobado_direccion != 1){
                array_push($emails, trim($sql[$i]->administracion_email)); 
                array_push($emails, trim($sql[$i]->director_comercial_email));  
                array_push($emails, trim($sql[$i]->director_operaciones_email));  
                array_push($emails, trim($sql[$i]->director_general_email));  
               }
               
               $emails_filter = Arr::where($emails, function ($value, $key) {
                return $value != '';
               });
                      
               $this->sentEmailReminder($sql[$i]->documentp_id, $emails_filter);  
            }
        }

        $this->info('Comman Completed.');
        
    }
   
    public function sentEmailReminder($id_doc, $emails)
    {
      $doc = Documentp::findOrFail($id_doc);
      $folio = $doc->folio;

      if($doc->nombre_proyecto == null || $doc->nombre_proyecto == ''){
        $sql = DB::table('hotels')->select('id','Nombre_hotel')->where('id', $doc->anexo_id)->get();
        $name_project = $sql[0]->Nombre_hotel;
      }else{
        $name_project = $doc->nombre_proyecto;
      }

      $parametros = [
        'folio' => $folio,
        'nombre_proyecto' => $name_project,
      ];

      Mail::to('rkuman@sitwifi.com')->cc($emails)->send(new NewKickoffProject($parametros));
    }

}

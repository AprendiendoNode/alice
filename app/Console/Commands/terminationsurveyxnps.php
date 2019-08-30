<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use DB;

use Mail;
use App\Mail\Sentsurveynpsmail;
use Illuminate\Support\Facades\Crypt;

class terminationsurveyxnps extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'termination:nps';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Comando diario, revisa todas las encuestas que caduquen para desactivarlas.';

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
        //$encuesta_ids = [];
        //$data_emails = [];
        //$data_update = array();

        // $fechaini = "2018-04-01";
        // $fechafin = "2018-04-30";
        // $fecha_cur = "2018-04-01";
        // $mesanteriorfull = "2018-03-01";

        $fechaini = date('Y-m-01');
        $fechafin = date('Y-m-t');
        $fecha_cur = date('Y-m-d');

        $mesanterior = strtotime ( '-1 month' , strtotime ( $fecha_cur ) ) ;
        $mesanterior = date ( 'Y-m' , $mesanterior );

        $mesanteriorfull = $mesanterior . '-01';

        $sql = DB::select('CALL Termination_Surveys(?)', array($fecha_cur));

        $sql_count = count($sql);

        DB::beginTransaction();
        for ($i=0; $i < $sql_count; $i++) { 
            $id_encuestauser = $sql[$i]->id;
            $this->line('Current iteration: ' . $i);
            $this->info('id de encuesta_user ha realizar update: ' . $id_encuestauser);
            // $nuevolink = $sql[$i]->id.'/'.'1'.'/'.$mesanteriorfull.'/'.$fechafin;
            // $encriptodata= Crypt::encryptString($nuevolink);
            //$encriptostatustest= Crypt::encryptString('1');
            //$data_update = array_add(['estatus_id' => 2], 'shell_status', $encriptostatus);
            $encriptostatus = Crypt::encryptString('2');
            //$sql2 = DB::table('users')->select('email', 'name')->where('id', $sql[$i]->user_id)->get();
            // array_push($data_emails, 
            //     [
            //         'name' => $sql2[$i]->name, 
            //         'shellstatus' => $encriptostatus
            //     ]);
            //array_push($encuesta_ids, $sql[$i]->id);
            // array_push($data_update, [
            //     'estatus_id' => 2, 
            //     'shell_status' => $encriptostatus
            // ]);

            $res = DB::table('encuesta_users')->where('id', $id_encuestauser)->update(['estatus_id' => 2, 'shell_status' => $encriptostatus]);

        }
        DB::commit();
        //$res = DB::table('encuesta_users')->whereIn('id', $encuesta_ids)->update($data_update);

        //$this->line($sql);
        //dd($sql);
        $this->info('Command Completed.');
    }

    public function sentSurveyEmail($email, $data)
    {
        //$this->line('Current Iteration: ' . $i);
        //dd($data[0]['email']);

        $data_count = count($data);
        for ($i=0; $i < $data_count; $i++) { 
            $nombre = $data[$i]['name'];
            $correo = $data[$i]['email'];
            $shell1 = $data[$i]['shelldata'];
            $shell2= $data[$i]['shellstatus'];

            $datos = [
                'nombre' => $nombre,
                'shell_data' => $shell1,
                'shell_status' => $shell2,
            ];
            $this->line('Sending Email to: ' . $nombre . ', ' . $correo);
            //Mail::to('jesquinca@sitwifi.com')->send(new Sentsurveynpsmail($datos));
            //Mail::to($email)->send(new Sentsurveynpsmail($data));
        }
    }

}

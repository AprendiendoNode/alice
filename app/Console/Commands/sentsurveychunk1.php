<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use DB;
use Mail;
use App\Mail\SendEmailSurvey;
use Illuminate\Support\Facades\Crypt;

class sentsurveychunk1 extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'survey:nps1 {result*}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Comando que recibe todas las encuestas por partes para que no se trabe (En prueba!)';

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

        $fechaini = date('Y-m-01');
        $fechafin = date('Y-m-t');
        $fecha_cur = date('Y-m');

        $mesanterior = strtotime ( '-1 month' , strtotime ( $fecha_cur ) ) ;
        $mesanterior = date ( 'Y-m' , $mesanterior );
        $mesanteriorfull = $mesanterior . '-01';

        $sql = $this->argument('result');
        $sql_count = count($sql);

        for ($i=0; $i < $sql_count; $i++) {
            $this->line('Current Iteration: ' . $i);
            $nuevolink = $sql[$i]->id.'/'.'2'.'/'.$mesanteriorfull.'/'.$fechafin.'/'.'1';
            $encriptodata= Crypt::encryptString($nuevolink);
            $encriptostatus= Crypt::encryptString('1');

            $data_emails = [
                'nombre' => $sql[$i]->name,
                'shell_data' => $encriptodata,
            ];
            $data_insert = [
                'user_id' => $sql[$i]->id,
                'survey_id' => 2,
                'estatus_id' => 1,
                'estatus_res' => 1,
                'fecha_inicial' => $fechaini,
                'fecha_corresponde' => $mesanteriorfull,
                'fecha_fin' => $fechafin,
                'shell_data' => $encriptodata,
                //'shell_status' => $encriptostatus
            ];

            $this->line('email: ' . $sql[$i]->email);
            $this->line('nombre: ' . $sql[$i]->name);
            // Descomentar para hacer la prueba REAL el 01 de Noviembre del 2019.

            $res = DB::table('surveydinamic_users')->insert($data_insert);
            if ($res) {
                $this->line('Datos Insertados.');
            }else{
                $this->error('no se insertaron datos.');
            }
            // $this->line('http://alice.sitwifi.com/'.$encriptodata.'/'.$encriptostatus);
            $this->line('Sending Email to: ' . $sql[$i]->name . ', ' . $sql[$i]->email);
            
            // $this->line('Así quedaria el enlace = http://alice.sitwifi.com/'.$encriptodata.'/'.$encriptostatus);
            
            // Descomentar para hacer la prueba REAL el 01 de Noviembre del 2019.
            $correo = trim($sql[$i]->email);
            Mail::to($correo)->send(new SendEmailSurvey($data_emails));
        }
        $this->info('Command Chunk completed.');
    }
}

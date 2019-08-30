<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use DB;

class testxcommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'test:test';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

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
    public function xxxx()
    {

        // Encuestas clientes.
        //$sql = DB::table('encuesta_user_clientes')->get(); 
        // Encuestas personales (sitwifi).
        //$sql = DB::table('encuesta_user_sitwifi')->get();

        //$res1 = DB::table('encuesta_user_clientes')->select('email', 'Special')->where('id_eu', 2)->get();
        //$res2 = DB::table('encuesta_users')->select('user_id', 'estatus_res', 'shell_data', 'shell_status')->where('id', 2)->get();
        //$res3 = DB::table('encuesta_users')->where('id', 2)->get();

        //$res4 = DB::select('CALL buscar_venue_user(?)', array($res2[0]->user_id));
        $res5 = DB::select('CALL list_user_unanswer(?, ?)', array(2, '2018-04-01'));


        // $count = count($res4);
        // $string1 = "";

        // for ($i=0; $i < $count; $i++) { 
        //     $string1 = $string1 . $res4[$i]->Nombre_hotel . ", ";
        // }
        // $string1 = substr($string1, 0, -2);
        
        $res6= DB::select('CALL delivery_letter_venue_header(?)', array(4));
        $result = DB::select('CALL comments_table(?, ?)', array('2018-04-01', 2));
        $result1 = DB::select('CALL conteo_survey(?, ?)', array(2, '2018-04-01'));
        dd($res5);
    }

    public function handasdasdle()
    {
        $pass_to_hash = array('776487','694895','828783','581151','613409','181065','202960','216520','968118','426131','370969','376683','852843','412161','645204','398135','113250','218828','753374','580415','775034','900516','831692','900153','170234','295945','169009','755564','520590','571027','880240','331730','957317','274881','942770','979025','563060','401454','280370','657137','469045','511761','398030','553402','972331','442239','283211','829520','907152','402509','536347','606971','377843','453969','120880','388307','337536','930417','264925','743775','112851','199457','185953','987513','686428','569440','873383','742452','718535','612224','466707','789526','650818','201684','490139','537398','995565','230217','204564','118282','772947','226207','383050','247529','342826','991563','235684','650387','562020','790980','778762','343576','489817','569458','629133','842933','911987','445227','651685','274430','133438','743914');
        $count_hash = count($pass_to_hash);

        $hashes_real = [];

        $value = "";

        $this->info('count: '. $count_hash);
        for ($i=0; $i < $count_hash; $i++) { 
            $value = bcrypt($pass_to_hash[$i]);
            $this->line($value);
            array_push($hashes_real, $value);
        }

        // mi contraseña
        // $2y$10$6cnYDe2gio6v4pjjjT.cVuZ4P./idAEMIkaDnXP4KrDYMpGBlpm2y

        $count_hashes_real = count($hashes_real);
        $this->info('hashes_real: ' . $count_hashes_real);
        //dd($hashes_real);
        $this->info('Command ended successfuly.');  
    }

    public function haasdasdndle()
    {
        $hotel_reservas = 'HOTEL$Reservas';
        //$test = DB::connection('sqlsrv_bb')->select('SELECT "Reservas"."Ao", "Reservas"."Reserva", "Reservas"."Desglose", "Reservas"."Fecha entrada", "Reservas"."Fecha salida", "Reservas"."Noches", "Reservas"."Nacionalidad", "Reservas"."Apellido 1er_ Ocupante", "Reservas"."AD", "Reservas"."JR", "Reservas"."NI", "Reservas"."Estado reserva", "Reservas"."Habitacin" FROM [HOTEL$Reservas] as Reservas WITH (NOLOCK) WHERE "Reservas"."Estado reserva"=2 ORDER BY "Reservas"."Habitacin"');
        
        $test2 = DB::connection('sqlsrv_bb')->table('HOTEL$Reservas')->take(5);

        //$checkticket = DB::connection('sqlsrv_bb')->table('dbo.Chart')->first();
        // $algo = $test2->{'Source Counter'};
        print_r($test2);
        //$this->info('algo: ' . $algo);
        //dd($test2);
        //$res = DB::connection dbo.[Explotadora Hotel$Reservas]
    }

    // Comando para envio de encuestas no contestadas.
    public function handle()
    {
        $operacion = 0;
        $date_full = '2018-10-01';
        
        $encuesta_id = 1;

        // $result = DB::select('CALL list_user_unanswer(?, ?)', array($encuesta_id, $date_full));

        $array_test=[];
        // 'alonso' => 'acauich@sitwifi.com',
        // 'rodolfo' => 'rkuman@sitwifi.com',
        // 'Leon' => 'cleon@sitwifi.com',
        array_push($array_test, ['email' => 'jesquinca@sitwifi.com', 'name' => 'esquinca', 'shell_data' => 'asdasdasdxxx11', 'shell_status' => 'adhabsdha']);
        array_push($array_test, ['email' => 'acauich@sitwifi.com', 'name' => 'alonso', 'shell_data' => 'asdasdasd', 'shell_status' => 'adhabsdha']);
        array_push($array_test, ['email' => 'rkuman@sitwifi.com', 'name' => 'rodolfo', 'shell_data' => 'asdasdasdad22asd', 'shell_status' => 'adhabsdha']);
        array_push($array_test, ['email' => 'cleon@sitwifi.com', 'name' => 'leon', 'shell_data' => 'asdasdasdad22asd', 'shell_status' => 'adhabsdha']);

        $count = count($array_test);
        $this->line('called command==??');
    }

}
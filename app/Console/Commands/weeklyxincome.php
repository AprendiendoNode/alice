<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use DB;
use Mail;


class weeklyxincome extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'weekly:income';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Envío de correos semanales con el detalle de los ingresos efectuados en la misma.';

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
        $result = DB::select('CALL px_contracts_charges_ingresado()');
        $sumas = DB::select('CALL px_contracts_charges_ingresado_totales()');
        
        // $this->sentSurveyEmail($result, $result_sum);
        // $this->info('Command ended');

        dd($result, $sumas);
    }

    public function sentSurveyEmail($data, $data2)
    {
        $correos = ['aespejo@sitwifi.com','rgonzalez@sitwifi.com','jwalker@sitwifi.com', 'mmoreno@sitwifi.com', 'mlara@sitwifi.com', 'mortiz@sitwifi.com'];
        // Mail::to($correos)->send(new SolicitudConP($data, $data2));
        Mail::to('jesquinca@sitwifi.com')->send(new SolicitudConP($data, $data2));
    }
}

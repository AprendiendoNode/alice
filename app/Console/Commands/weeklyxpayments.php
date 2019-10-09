<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use DB;
use Mail;
use App\Mail\SolicitudConP;

class weeklyxpayments extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'weekly:pay';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Envío de correos semanales con el detalle de los pagos efectuados en la misma.';

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
        $parametros = [];
        $result = DB::select('CALL payments_fechasolicitud_pagado ()');
        /*for ($i=0; $i < count($result); $i++) {
            $this->line('Current Iteration: ' .$i);

            // capturado, revisado, aprobado
            // totales en mx y usd.
          array_push($parametros, ['factura' => $result[$i]->factura,
                                    'folio' => $result[$i]->folio,
                                    'proveedor' => $result[$i]->proveedor,
                                    'concepto' => $result[$i]->concepto,
                                    'monto' => $result[$i]->monto,
                                    'monto_str' => $result[$i]->monto_str,
                                    'fecha' => $result[$i]->fecha,
                                    'realizo' => $result[$i]->realizo,
                                    'autorizo' => $result[$i]->autorizo,
                                    'fecha_elaboro' => $result[$i]->fecha_elaboro,
                                    'elaboro' => $result[$i]->elaboro,
                                  ]);
        }*/
        $result_sum = DB::select('CALL payments_fechasolicitud_pagado_totales ()');
        $this->sentSurveyEmail($result, $result_sum);
        $this->info('Command ended');
    }

    public function sentSurveyEmail($data, $data2)
    {
        //código en rutas para activar correo en browser.
        // $param = [];
        // array_push($param, ['factura' => 'asasdas',
        //     'folio' => 'asdasd',
        //     'proveedor' => 'xxxsxas',
        //     'concepto' => 'kgbbglmkgf',
        //     'monto' => '1233.44',
        //     'monto_str' => 'MXN',
        //     'fecha' => 'asdbgn',
        //     'realizo' => 'xxcvdf',
        //     'fecha_elaboro' => 'dhfnb',
        //     'elaboro' => 'scdvhtn'
        // ]);
        //return new App\Mail\SolicitudConP($param);
        //Mail::to('jesquinca@sitwifi.com')->send(new Sentsurveynpsmail($datos));

        $correos = ['aespejo@sitwifi.com','rgonzalez@sitwifi.com','jwalker@sitwifi.com', 'mmoreno@sitwifi.com', 'mlara@sitwifi.com', 'mortiz@sitwifi.com'];

        Mail::to($correos)->send(new SolicitudConP($data, $data2));
        // Mail::to('jesquinca@sitwifi.com')->send(new SolicitudConP($data, $data2));
    }
}

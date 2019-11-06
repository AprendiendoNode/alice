<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use DB;
use Mail;
// use App\Mail\SolicitudConP;

class weeklyxviatics extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'weekly:viatic';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Envío de correos semanales con el detalle de los viáticos efectuados en la misma.';

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
        //
    }

    public function sentSurveyEmail($data, $data2)
    {
        $correos = ['aespejo@sitwifi.com','rgonzalez@sitwifi.com','jwalker@sitwifi.com', 'mmoreno@sitwifi.com', 'mlara@sitwifi.com', 'mortiz@sitwifi.com'];

        Mail::to($correos)->send(new SolicitudConP($data, $data2));
        // Mail::to('jesquinca@sitwifi.com')->send(new SolicitudConP($data, $data2));
    }
}

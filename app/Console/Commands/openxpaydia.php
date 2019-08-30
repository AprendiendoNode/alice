<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use Openpay;

class openxpaydia extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'open:dia';

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
    public function handle()
    {
        Openpay::setId('mrbligxkubjgct2a2vrd');
        Openpay::setApiKey('sk_7d8cfb248e4e4395a7ee80629decc6f2');

        Openpay::setProductionMode(true);

        $openpay = Openpay::getInstance('mrbligxkubjgct2a2vrd', 'sk_7d8cfb248e4e4395a7ee80629decc6f2');
        
        $datenow = date('Y-m-d');

        $findData = array(
            'creation[gte]' => $datenow,
            'creation[lte]' => $datenow,
            'limit' => 200,
            //'status' => 'FAILED'
        );

        $chargeList = $openpay->charges->getList($findData);
        //$charge = $openpay->charges->get('trzjz0azwjftwugfpzdh');
        // return $chargeList;
        //$algo = $chargeList[0]->card->brand;

        $countar = count($chargeList);

        dd($countar);
    }

    public function test()
    {
        Openpay::setId('mrbligxkubjgct2a2vrd');
        Openpay::setApiKey('sk_7d8cfb248e4e4395a7ee80629decc6f2');

        Openpay::setProductionMode(true);

        $openpay = Openpay::getInstance('mrbligxkubjgct2a2vrd', 'sk_7d8cfb248e4e4395a7ee80629decc6f2');
        
        $datenow = date('Y-m-d');

        $findData = array(
            'creation[gte]' => $datenow,
            'creation[lte]' => $datenow,
            'limit' => 200,
            //'status' => 'FAILED'
        );

        $chargeList = $openpay->charges->getList($findData);
        //$charge = $openpay->charges->get('trzjz0azwjftwugfpzdh');

        // return $chargeList;
        //$algo = $chargeList[3]->card->brand;
        dd($chargeList);
    }

}

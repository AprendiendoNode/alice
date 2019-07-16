<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Base\ExchangeRate;
use DB;

class enchangeratefix extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'exchangerate:fix';

    protected $description = 'Insercion Tipo de cambio USD FIX desde API banxico.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
      $result = ExchangeRate::getExchangeRateFix();

      dd($result);

      $data = $result['bmx']['series'];
      $series = $data[0]['datos'];

      $current_date = $series[0]['fecha'];
      $current_date = str_replace('/', '-', $current_date );
      $current_date = date("Y-m-d", strtotime($current_date));

      $current_rate = $series[0]['dato'];
      $code_banxico =$data[0]['idSerie'];

      DB::table('exchange_rates')->insert([
        'current_date' => $current_date,
        'currency_id' => 2,
        'code_banxico' => $code_banxico,
        'current_rate_fix' => $current_rate,
        'modified_rate' => $current_rate,
        'status' => 1,
        'created_uid' => 2,
        'updated_uid' => 2,
        'created_at' => \Carbon\Carbon::now()
      ]);
    }


}

<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Base\ExchangeRate;
use Carbon\Carbon;
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
      $mutable = Carbon::now();
      // $mutable = Carbon::create(2019, 7, 23, 0);
      // $mutable = Carbon::create(2019, 7, 13, 0)->format('Y-m-d');
      // $friday = $mutable->subDays(3)->format('Y-m-d');
      
      $data = $result['bmx']['series'];
      $series = $data[0]['datos'];

      $banxico_date = $series[0]['fecha'];
      $banxico_date = str_replace('/', '-', $banxico_date );
      $banxico_date_string = date("Y-m-d", strtotime($banxico_date));
      $varx = 0;
      switch ($mutable) {
        case $mutable->isSaturday():
          $latest = DB::table('exchange_rates')->latest()->first();
          $fix_rate = 0.0000;
          $dof_rate = 0.0000;
          $current_rate = $latest->current_rate_dof;
          $code_banxico =$data[0]['idSerie'];
          $varx = 1;
          break;
        case $mutable->isSunday():
          $latest = DB::table('exchange_rates')->latest()->first();
          $fix_rate = 0.0000;
          $dof_rate = 0.0000;
          $current_rate = $latest->current_rate;
          $code_banxico =$data[0]['idSerie'];
          $varx = 2;
          break;
        case $mutable->isMonday():
          $friday = $mutable->subDays(3)->format('Y-m-d');
          $latest = DB::table('exchange_rates')->where('current_date', $friday)->first();
          $fix_rate = $series[0]['dato'];
          $dof_rate = $latest->current_rate_fix;
          $current_rate = $latest->current_rate_dof;
          $code_banxico =$data[0]['idSerie'];
          $varx = 3;
          break;
        default:
          $latest = DB::table('exchange_rates')->latest()->first();
          $fix_rate = $series[0]['dato'];
          $dof_rate = $latest->current_rate_fix;
          $current_rate = $latest->current_rate_dof;
          $code_banxico =$data[0]['idSerie'];
          // dd('banxico api fix: ' . $fix_rate, 'dof_bd: ' . $latest->current_rate_dof, 'fix_bd: ' . $latest->current_rate_fix);
          $varx = 4;
          break;
      }
            
      $data_insert = [
        'current_date' => $mutable->format('Y-m-d'),
        'currency_id' => 2,
        'code_banxico' => $code_banxico,
        'current_rate_fix' => $fix_rate,
        'current_rate_dof' => $dof_rate,
        'current_rate' => $current_rate,
        'modified_rate' => $current_rate,
        'status' => 1,
        'created_uid' => 2,
        'updated_uid' => 2,
        'created_at' => Carbon::now()
      ];
      $this->insertExchange($data_insert);
      $this->info('Datos insertados correctamente, comando completado.');
      // dd($data_insert, 'Datos insertados.');

    }
    public function insertExchange($data)
    {
      DB::table('exchange_rates')->insert($data);
    }

}

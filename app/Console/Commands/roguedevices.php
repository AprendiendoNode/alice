<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use DB;
use SNMP;
use Mail;
use App\User; //Importar el modelo eloquent
use App\Hotel; //Importar el modelo eloquent
use App\Zonedirect_ip; //Importar el modelo eloquent
use App\Rouguedevice; //Importar el modelo eloquent
use App\Mail\CmdAlerts;
use Jenssegers\Date\Date;
class roguedevices extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'rougue:mes';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Comando para registrar la informacion de devices rogue';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }
    public function trySNMP_oid($ip, $oid)
    {
      $res = array();
      $boolean = 0;
      $session = new SNMP(SNMP::VERSION_2C, $ip, "public");
      try {
        $res = $session->walk($oid);
      } catch (\Exception $e) {
        if ( $session->getErrno() == SNMP::ERRNO_TIMEOUT ) {
          $res = array();
        }
        return $res;
      }
      $session->close();
      return $res;
    }


    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
      $zoneDirect_sql = Zonedirect_ip::select('ip','hotel_id', 'oid_id')->where('status', '!=', 3)->get();
      $contar_ip= count($zoneDirect_sql); //Cuento el tamaño del array anterior
      $this->info('Cantidad de registros= '.($contar_ip-1));
      $boolean = 0;
      $var_sum_reg=1;
      Rouguedevice::truncate();
      Date::setLocale('en');
      for ($i=0; $i < $contar_ip; $i++) {
        $host=$zoneDirect_sql[$i]->ip;
        $hotel=$zoneDirect_sql[$i]->hotel_id;
        /*Contar los usuarios*/
        $email_user = Hotel::find($hotel);
        $result_proced = DB::select('CALL setemailsnmp (?)', array($hotel));
        $total_user_x_hotel = count($result_proced);
        $this->info('Hotel='.$hotel);
        /*Fin Contar los usuarios*/
        $boolean = $this->trySNMP($host);

        if ($boolean === 0){
          $this->info("Ping successful!");
          ${"snmp_a".$i} = $this->trySNMP_oid($host, '1.3.6.1.4.1.25053.1.2.2.1.1.4.1.1.1'); //Rogue device's MAC Address.
          ${"snmp_b".$i} = $this->trySNMP_oid($host, '1.3.6.1.4.1.25053.1.2.2.1.1.4.1.1.4'); //Radio channel.
          ${"snmp_c".$i} = $this->trySNMP_oid($host, '1.3.6.1.4.1.25053.1.2.2.1.1.4.1.1.3'); //Radio type.
          ${"snmp_d".$i} = $this->trySNMP_oid($host, '1.3.6.1.4.1.25053.1.2.2.1.1.4.1.1.2'); //SSID.
          $contar_act= count(${"snmp_a".$i});
          DB::beginTransaction();
          for ($j=0; $j < $contar_act-1; $j++) {
            $contar_param_1= count(${"snmp_a".$i});
            $contar_param_2= count(${"snmp_b".$i});
            $contar_param_3= count(${"snmp_c".$i});
            $contar_param_4= count(${"snmp_d".$i});
            if ( empty($contar_param_1) || empty($contar_param_2) || empty($contar_param_3)  || empty($contar_param_4)) {
              echo '/Error encontrado';
            }
            else {
              //Para obtener la MAC Address.
              ${"snmp_aa".$i}= explode(': ', ${"snmp_a".$i} [key(${"snmp_a".$i})]);
              next(${"snmp_a".$i}); //Este es para que avance la key en el array

              //Para obtener el radio channel
              ${"snmp_ab".$i}= explode(': ', ${"snmp_b".$i} [key(${"snmp_b".$i})]);
              next(${"snmp_b".$i}); //Este es para que avance la key en el array

              //Para obtener el radio type
              ${"snmp_ac".$i}= explode(': ', ${"snmp_c".$i} [key(${"snmp_c".$i})]);
              next(${"snmp_c".$i}); //Este es para que avance la key en el array

              //---------------------------------------
              // var_dump(${"snmp_aa".$i}[1]);
              // echo $parmt_a = '/-Mac: '.${"snmp_aa".$i}[1];
              // echo $parmt_b = '-Radio:'.${"snmp_ab".$i}[1];
              // echo $parmt_c = '-Type: '.${"snmp_ac".$i}[1];
              // echo $parmt_d = '-SSID: '.${"snmp_d".$i} [key(${"snmp_d".$i})].'/';
              // echo $Mesitho =Date::now()->format('F Y');
              // echo '/';
              // echo Date::now()->format('Y-m-d');
              // echo '/';
              // echo $hotel.'/';
              //---------------------------------------

              $eliminar_ultimocaracter = trim(${"snmp_aa".$i}[1], ' ');
              $mac_with_point = str_replace(' ',':',$eliminar_ultimocaracter);

              $elim_string = str_replace('STRING:','',${"snmp_d".$i} [key(${"snmp_d".$i})]);
              $elim_comas = str_replace('"','',$elim_string);

              if (strlen ($mac_with_point) == '17') {
                ${"Rouguedevice".$i} = new Rouguedevice;
                ${"Rouguedevice".$i}->MACRogue= $mac_with_point;
                ${"Rouguedevice".$i}->ChannelRogue= ${"snmp_ab".$i}[1];
                ${"Rouguedevice".$i}->TypeRogue= ${"snmp_ac".$i}[1];
                if (!empty($elim_comas)) {
                  $ssid_a= $elim_comas;
                  ${"Rouguedevice".$i}->SSIDRogue= $ssid_a;
                }
                ${"Rouguedevice".$i}->Mes= Date::now()->format('F Y');
                ${"Rouguedevice".$i}->hotels_id= $hotel;
                ${"Rouguedevice".$i}->valor= $var_sum_reg;
                ${"Rouguedevice".$i}->fecha = Date::now()->format('Y-m-d');
                ${"Rouguedevice".$i}->save();
              }

            }
          }
          DB::commit();
        }
        else {
          $this->info("Ping unsuccessful!");
           /*-------------------------VERIFICACIONES DE USUARIOS-----------------------------------------
           echo "Ping unsuccessful!";
           if ($total_user_x_hotel >= '1' ) {//Mas de un usuario asignado al hotel.
             for ($j=0; $j <$total_user_x_hotel; $j++) {
               $it_name = $email_user->usuarios[$j]->name;
               $it_correo = $email_user->usuarios[$j]->email;
               $it_correos= 'acauich@sitwifi.com';
               $asunt = 'Rougue Devices';
               $data = [
                 'asunto' => $asunt,
                 'ip' => $host,
                 'hotel' => $email_user->Nombre_hotel,
                 'nombre' => $it_name,
                 'mensaje' => 'Favor de capturar los rougue devices en dado caso que existan en el sistema de reportes. Los datos a capturar son pertenecientes a la fecha del ',
                 'fecha' => Date::now()->format('l j F Y H:i:s')
               ];
               Mail::to($it_correos)->bcc('alonsocauichv1@gmail.com')->send(new CmdAlerts($data));
             }
           }
           -------------------------VERIFICACIONES DE USUARIOS-----------------------------------------*/
        }


      }
    }
    public function trySNMP($ip)
    {
      $boolean = 0;
      $session = new SNMP(SNMP::VERSION_2C, $ip, "public");
      try {
        $res = $session->walk('1.3.6.1.4.1.25053.1.2.2.1.1.4.1.1.1'); //Rogue device's MAC Address.
      } catch (\Exception $e) {
        if ( $session->getErrno() == SNMP::ERRNO_TIMEOUT ) {
          $boolean = 1;
        }
        return $boolean;
      }
      $session->close();
      return $boolean;
    }
}

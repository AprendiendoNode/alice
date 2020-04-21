<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use DB;
use SNMP;
use Mail;
use App\User; //Importar el modelo eloquent
use App\Hotel; //Importar el modelo eloquent
use App\Zonedirect_ip; //Importar el modelo eloquent
use App\Mostap; //Importar el modelo eloquent
use App\Mail\CmdAlerts;
use Jenssegers\Date\Date;
class mostapxdia extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ap:dia';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Comando para capturar la mac, modelo de aps, ademas del numero de usuarios autentificados';

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
      // Mostap::truncate();
      Date::setLocale('en');
      //Creo un ciclo for para recorrer las posiciones del array
      for ($i=0; $i < ($contar_ip-1); $i++) {
        $host=$zoneDirect_sql[$i]->ip;
        $hotel=$zoneDirect_sql[$i]->hotel_id;
        /*Contar los usuarios*/
        $email_user = Hotel::find($hotel);
        $result_proced = DB::select('CALL setemailsnmp (?)', array($hotel));
        $total_user_x_hotel = count($result_proced);
        /*Fin Contar los usuarios*/

        $boolean = $this->trySNMP($host);

        if ($boolean === 0){
          //echo "Ping successful!";
          ${"snmp_aps_a".$i} = $this->trySNMP_oid($host, '1.3.6.1.4.1.25053.1.2.2.1.1.2.1.1.4');//Model name
          ${"snmp_aps_b".$i} = $this->trySNMP_oid($host, '1.3.6.1.4.1.25053.1.2.2.1.1.2.1.1.15');//Total number of authenticated terminal which is using currently on this AP
          ${"snmp_aps_c".$i} = $this->trySNMP_oid($host, '1.3.6.1.4.1.25053.1.2.2.1.1.2.1.1.1');//MAC address
          $contar_aps_act= count(${"snmp_aps_a".$i});

          DB::beginTransaction();
          for ($j=0; $j <= ($contar_aps_act-1); $j++) {
            $contar_param_1= count(${"snmp_aps_a".$i});
            $contar_param_2= count(${"snmp_aps_b".$i});
            $contar_param_3= count(${"snmp_aps_c".$i});
            if ( empty($contar_param_1) || empty($contar_param_2) || empty($contar_param_3)) {
              echo '/Error encontrado';
            }
            else{
              //Para el modelo de aps
              ${"snmp_aps_aa".$i}= explode(': ', ${"snmp_aps_a".$i} [key(${"snmp_aps_a".$i})]);
              // var_dump(${"snmp_aps_aa".$i});
              next(${"snmp_aps_a".$i}); //Este es para que avance la key en el array

              // Total number of authenticated terminal which is using currently on this AP
              ${"snmp_aps_ab".$i}= explode(': ', ${"snmp_aps_b".$i} [key(${"snmp_aps_b".$i})]) ;
              next(${"snmp_aps_b".$i}); //Este es para que avance la key en el array

              //Para la mac de apache_get_modules
              ${"snmp_aps_ac".$i}= explode(': ', ${"snmp_aps_c".$i} [key(${"snmp_aps_c".$i})]) ;
              next(${"snmp_aps_c".$i}); //Este es para que avance la key en el array

              // echo $mac_a = '/-Mac: '.${"snmp_aps_ac".$i}[1];
              // echo $mac_b = '-Modelo: '.${"snmp_aps_aa".$i}[1];
              // echo $mac_c = '-NumClientes: '.${"snmp_aps_ab".$i}[1].'/';
              // echo $Mesitho =Date::now()->format('F Y');
              // echo '/';
              // echo Date::now()->format('Y-m-d');
              // echo '/';
              // echo $hotel.'/';

              $eliminar_ultimocaracter = trim(${"snmp_aps_ac".$i}[1], ' ');
              $mac_with_point = str_replace(' ',':',$eliminar_ultimocaracter);

              ${"Mostap".$i} = new Mostap;
              ${"Mostap".$i}->Fecha = Date::now()->format('Y-m-d');
              ${"Mostap".$i}->MAC= $mac_with_point;
              ${"Mostap".$i}->NumClientes = ${"snmp_aps_ab".$i}[1];
              if ( empty(${"snmp_aps_aa".$i}[1])) {
                ${"Mostap".$i}->Modelo='';
              }
              else {
                ${"Mostap".$i}->Modelo= str_replace('"','',${"snmp_aps_aa".$i}[1]);
              }
              ${"Mostap".$i}->Mes= Date::now()->format('F Y');
              ${"Mostap".$i}->hotels_id= $hotel;
              ${"Mostap".$i}->save();

              $this->info('hotel'.$hotel);
            }
          }
          DB::commit();
        }
        else {
          //  echo "Ping unsuccessful!";
           /*-------------------------VERIFICACIONES DE USUARIOS-----------------------------------------*/
           if ($total_user_x_hotel >= '1' ) {//Mas de un usuario asignado al hotel.
             for ($j=0; $j <$total_user_x_hotel; $j++) {
               $it_name = $result_proced[$j]->name;
               $it_correo = $result_proced[$j]->email;
               $it_correos= 'acauich@sitwifi.com';
               $asunt = 'Top 5 de Ap&#8216;s';
               $data = [
                 'asunto' => $asunt,
                 'ip' => $host,
                 'hotel' => $email_user->Nombre_hotel,
                 'nombre' => $it_name,
                 'mensaje' => 'Favor de capturar el top 5 de ap&#8216;s de manera manual en el sistema de reportes. Los datos a capturar son pertenecientes a la fecha del ',
                 'fecha' => Date::now()->format('l j F Y H:i:s')
               ];
               $this->info('ENVIO UNICO= '.$it_correo);
               //Mail::to($it_correo)->bcc(['acauich@sitwifi.com', 'rkuman@sitwifi.com', 'jesquinca@sitwifi.com'])->send(new CmdAlerts($data));
               Mail::to($it_correo)->send(new CmdAlerts($data));
             }
           }
           else {
             $data = [
               'asunto' => 'Top 5 de Ap&#8216;s',
               'ip' => $host,
               'hotel' => $email_user->Nombre_hotel,
               'nombre' => 'No disponible',
               'mensaje' => 'Favor de revisar el motivo de la no conexion y de capturar sus datos pertenecientes a la fecha del ',
               'fecha' => Date::now()->format('l j F Y H:i:s')
             ];
             $this->info('ENVIO UNICO ADMIN');
             //Mail::to(['acauich@sitwifi.com', 'rkuman@sitwifi.com', 'jesquinca@sitwifi.com'])->send(new CmdAlerts($data));
             Mail::to($it_correo)->send(new CmdAlerts($data));
           }
           /*-------------------------VERIFICACIONES DE USUARIOS-----------------------------------------*/
        }
      }
    }
    public function trySNMP($ip)
    {
      $boolean = 0;
      $session = new SNMP(SNMP::VERSION_2C, $ip, "public");
      try {
        $res = $session->walk('1.3.6.1.4.1.25053.1.2.2.1.1.2.1.1.4'); //Model name
      } catch (\Exception $e) {
        //var_dump($session->getErrno() == SNMP::ERRNO_TIMEOUT);
        if ( $session->getErrno() == SNMP::ERRNO_TIMEOUT ) {
          $boolean = 1;
        }
        return $boolean;
      }
      $session->close();
      return $boolean;
    }
}

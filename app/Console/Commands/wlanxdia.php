<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use DB;
use SNMP;
use Mail;
use App\User; //Importar el modelo eloquent
use App\Hotel; //Importar el modelo eloquent
use App\Zonedirect_ip; //Importar el modelo eloquent
use App\Wlan; //Importar el modelo eloquent
use App\Mail\CmdAlerts;
use Jenssegers\Date\Date;
class wlanxdia extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'wlan:dia';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Comando para registrar las wlan con el numero de clientes';

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
      //Wlan::truncate();
      Date::setLocale('en');
      //Creo un ciclo for para recorrer las posiciones del array
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
          $this->info('Ping successful!');
          ${"snmp_a".$i} = $this->trySNMP_oid($host, '1.3.6.1.4.1.25053.1.2.2.1.1.1.1.1.1');//Name of WLANS
          ${"snmp_b".$i} = $this->trySNMP_oid($host, '1.3.6.1.4.1.25053.1.2.2.1.1.1.1.1.12');//Number of client devices
          $contar_wlan_act= count(${"snmp_a".$i}); //Cuento el tamaño del array anterior
          DB::beginTransaction();
          for ($j=0; $j <$contar_wlan_act; $j++) {
            $contar_param_1= count(${"snmp_a".$i});
            $contar_param_2= count(${"snmp_b".$i});
            if ( empty($contar_param_1) || empty($contar_param_2)) {
              echo '/Error encontrado';
            }
            else{
              //Para obtener el nombre de WLANS
              ${"snmp_aa".$i}= explode(': ', ${"snmp_a".$i} [key(${"snmp_a".$i})]);
              next(${"snmp_a".$i}); //Este es para que avance la key en el array
              $elim_comas = str_replace('"','',${"snmp_aa".$i}[1]);

              //Para obtener el numero de dispositivos clientes
              ${"snmp_ab".$i}= explode(': ', ${"snmp_b".$i} [key(${"snmp_b".$i})]);
              next(${"snmp_b".$i}); //Este es para que avance la key en el array

              //echo ${"snmp_aa".$i}[1]; echo ${"snmp_ab".$i}[1];
              ${"Wlan".$i} = new Wlan;
              ${"Wlan".$i}->NombreWLAN= $elim_comas;
              ${"Wlan".$i}->ClientesWLAN= ${"snmp_ab".$i}[1];
              ${"Wlan".$i}->Fecha = Date::now()->format('Y-m-d');
              ${"Wlan".$i}->Mes= Date::now()->format('F Y');
              ${"Wlan".$i}->hotels_id= $hotel;
              ${"Wlan".$i}->save();
            }
          }
          DB::commit();
        }
        else{
          $this->info('Ping unsuccessful!');
          /*-------------------------VERIFICACIONES DE USUARIOS-----------------------------------------*/
          // echo "Ping unsuccessful!";
          if ($total_user_x_hotel >= '1' ) {//Mas de un usuario asignado al hotel.
            for ($j=0; $j <$total_user_x_hotel; $j++) {
              $it_name = $result_proced[$j]->name;
              $it_correo = $result_proced[$j]->email;
              $asunt = 'Top 5 de Wlan';
              $data = [
                'asunto' => $asunt,
                'ip' => $host,
                'hotel' => $email_user->Nombre_hotel,
                'nombre' => $it_name,
                'mensaje' => 'Favor de capturar el top 5 de wlan de manera manual en el sistema de reportes. Los datos a capturar son pertenecientes a la fecha del ',
                'fecha' => Date::now()->format('l j F Y H:i:s')
              ];
              $this->info('ENVIO a= '.$it_correo);
              //Mail::to($it_correo)->bcc(['acauich@sitwifi.com', 'rkuman@sitwifi.com', 'jesquinca@sitwifi.com'])->send(new CmdAlerts($data));
              Mail::to($it_correo)->send(new CmdAlerts($data));
            }
          }
          else {
            $data = [
              'asunto' => 'Top 5 de Wlan',
              'ip' => $host,
              'hotel' => $email_user->Nombre_hotel,
              'nombre' => 'No disponible',
              'mensaje' => 'Favor de revisar el motivo de la no conexion y de capturar sus datos pertenecientes a la fecha del ',
              'fecha' => Date::now()->format('l j F Y H:i:s')
            ];
            $this->info('ENVIO MASIVO ADMIN');
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

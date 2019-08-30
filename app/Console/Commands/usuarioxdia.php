<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use DB;
use SNMP;
use Mail;
use App\User; //Importar el modelo eloquent
use App\Hotel; //Importar el modelo eloquent
use App\Zonedirect_ip; //Importar el modelo eloquent
use App\Usuariosxdia; //Importar el modelo eloquent
use App\Mail\CmdAlerts;
use Jenssegers\Date\Date;
class usuarioxdia extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'usuario:dia';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Comando para registrar los usuarios por dia';

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
      //Usuariosxdia::truncate();
      Date::setLocale('en');
      for ($i=0; $i < $contar_ip; $i++) {
        $host=$zoneDirect_sql[$i]->ip;
        $hotel=$zoneDirect_sql[$i]->hotel_id;
        $this->info('Hotel='.$hotel);
        /*Contar los usuarios*/
        $email_user = Hotel::find($hotel);
        $result_proced = DB::select('CALL setemailsnmp (?)', array($hotel));
        $total_user_x_hotel = count($result_proced);
        /*Fin Contar los usuarios*/
        $boolean = $this->trySNMP($host);
        if ($boolean === 0){
          $this->info('Ping successful!');
          ${"snmp_a".$i} = $this->trySNMP_oid($host, '1.3.6.1.4.1.25053.1.2.1.1.1.15.2');//Number of authorized client devices
          ${"snmp_a".$i}= array_shift(${"snmp_a".$i});
          ${"snmp_a".$i}= explode(': ', ${"snmp_a".$i});

          ${"usuario".$i} = new Usuariosxdia;
          ${"usuario".$i}->NumClientes = ${"snmp_a".$i}[1];
          ${"usuario".$i}->Fecha = Date::now()->format('Y-m-d');
          ${"usuario".$i}->Mes= Date::now()->format('F Y');
          ${"usuario".$i}->hotels_id= $hotel;
          ${"usuario".$i}->save();
        }
        else {
          $this->info('Ping unsuccessful!');
          /*-------------------------VERIFICACIONES DE USUARIOS-----------------------------------------*/
          if ($total_user_x_hotel >= '1' ) {//Mas de un usuario asignado al hotel.
            for ($j=0; $j <$total_user_x_hotel; $j++) {
              $it_name = $result_proced[$j]->name;
              $it_correo = $result_proced[$j]->email;
              $it_correos= 'acauich@sitwifi.com';
              $asunt = 'Número de clientes autorizados';
              $data = [
                'asunto' => $asunt,
                'ip' => $host,
                'hotel' => $email_user->Nombre_hotel,
                'nombre' => $it_name,
                'mensaje' => 'Favor de capturar el número de dispositivos cliente autorizados de manera manual en el sistema de reportes. Los datos a capturar son pertenecientes a la fecha del ',
                'fecha' => Date::now()->format('l j F Y H:i:s')
              ];
              //Mail::to($it_correos)->bcc('alonsocauichv1@gmail.com')->send(new CmdAlerts($data));
              $this->info('ENVIO MASIVO');
              Mail::to($it_correo)->bcc(['acauich@sitwifi.com', 'rkuman@sitwifi.com', 'jesquinca@sitwifi.com'])->send(new CmdAlerts($data));
            }
          }
          else {
            $data = [
              'asunto' => 'Número de clientes autorizados',
              'ip' => $host,
              'hotel' => $email_user->Nombre_hotel,
              'nombre' => 'No disponible',
              'mensaje' => 'Favor de revisar el motivo de la no conexion y de capturar sus datos pertenecientes a la fecha del ',
              'fecha' => Date::now()->format('l j F Y H:i:s')
            ];
            $this->info('ENVIO UNICO ADMIN');
            Mail::to(['acauich@sitwifi.com', 'rkuman@sitwifi.com', 'jesquinca@sitwifi.com'])->send(new CmdAlerts($data));
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
        $res = $session->walk('1.3.6.1.4.1.25053.1.2.1.1.1.15.2');//Number of authorized client devices.
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

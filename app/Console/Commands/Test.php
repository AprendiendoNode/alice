<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use SNMP;
use Mail;
use App\User; //Importar el modelo eloquent
use App\Hotel; //Importar el modelo eloquent
use App\Zonedirect_ip; //Importar el modelo eloquent
use App\Mail\CmdAlerts;
use Jenssegers\Date\Date;
use Auth;
use DB;
use Illuminate\Support\Facades\Log;
use App\Mail\Sentsurveynpsmail;
use Illuminate\Support\Facades\Crypt;
use Carbon\Carbon;
use stdClass;
use ldap;

class Test extends Command
{
public $xmlreq=<<<XML
<?xml version="1.0" encoding="utf-8"?><soap:Envelope xmlns:soap="http://schemas.xmlsoap.org/soap/envelope/" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema"><soap:Body><Post_ObtenerInfoRoomPorHabitacion xmlns="http://localhost/xmlschemas/postserviceinterface/16-07-2009/"><RmroomRequest xmlns="http://localhost/pr_xmlschemas/hotel/01-03-2006/RmroomRequest.xsd"><Rmroom><hotel xmlns="http://localhost/pr_xmlschemas/hotel/01-03-2006/Rmroom.xsd"></hotel><room xmlns="http://localhost/pr_xmlschemas/hotel/01-03-2006/Rmroom.xsd"></room></Rmroom><rooms /></RmroomRequest></Post_ObtenerInfoRoomPorHabitacion></soap:Body></soap:Envelope>
XML;
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'test:prueba';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Prueba de Task Scheduling';

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
    // Llenado de presupuestos de todos los sitios.
    public function handle() // insercion de sites_budgets y annual_budgets en base a hotels.
    {
        $user = 2; //??
        $moneda = 2;
        $exchange_rate = 0.00;
        $status = 1;

        // $res = DB::table('sites_budgets')->get();
        $hotels = DB::table('hotels')->select('id','Nombre_hotel','id_ubicacion')->get();
        $hotel_count = count($hotels);
        // $hotels = DB::connection('alice_cloud')->table('hotels')->select('id','Nombre_hotel','id_ubicacion')->get();
        
        
        // dd('Alice',$hotels, $hotel_count);
        // sites_budgets
        // hotel_id, contract_annex_id, annual_budget_id, user_id
        // $contract_annex_id->isEmpty();

        // $contract_site = DB::table('contract_sites')->where('hotel_id', $hotels[0]->id)->get();
        // dd($contract_site);

        // $test1 = DB::table('contract_sites')->where('hotel_id', 3)->get();
        // $test2 = DB::table('contract_annexes')->where('id', 1)->get();
        // $test3 = DB::table('contract_payments')->where('contract_annex_id', 1)->first();

        // if ($test3->currency_id == 1) {
        //     $monto_adolar = (float) ($test3->quantity / 19.5); // multiplicado por dolares
        //     $monto_presupuesto = ($monto_adolar * 0.70);
        //     $monto_presupuesto = (float)number_format($monto_presupuesto, 2, '.','');
        //     $equipo_activo = ($monto_presupuesto * 0.70);
        //     $equipo_no_activo = ($monto_presupuesto * 0.20);
        //     $mano_obra = ($monto_presupuesto * .10);
        // }

        // $date_expiration = Carbon::create($test2[0]->date_real)->addMonths($test2[0]->number_expiration);
        
        // dd($monto_adolar, $monto_presupuesto, $equipo_activo, $equipo_no_activo, $mano_obra);
        // dd($test1, $test2 , $test3, $monto_presupuesto);
        // date_real + 36 meses.

        for ($i=0; $i < $hotel_count; $i++) {
            $this->info('Current iteration: ' . $i);
            $contract_site = DB::table('contract_sites')->where('hotel_id', $hotels[$i]->id)->get();
            $count_c = count($contract_site);
            if ($contract_site->isEmpty()) {
                $this->info('No tiene contrato: ' . $i);
                $id_annual = DB::table('annual_budgets')->insertGetId([
                    'user_id' => $user,
                    'fecha_budget' => '2020-01-01',
                    'estatus' => $status,
                    'moneda_id' => $moneda,
                    'exchange_rate' => $exchange_rate,
                    'id_ubicacion' => $hotels[$i]->id_ubicacion
                ]);
                DB::table('sites_budgets')->insert([
                    'hotel_id' => $hotels[$i]->id,
                    // 'contract_annex_id' => '',
                    'annual_budget_id' => $id_annual,
                    'user_id' => 2
                ]);
                $this->line('Presupuesto insertado');
            }else{
                if ($count_c > 1) {
                    $this->info('Tiene mas de 1 contrato anexo: ' . $count_c);
                    for ($j=0; $j < $count_c; $j++) {
                        // $contract_site[$j]->contract_annex_id
                        $annexes = DB::table('contract_annexes')->where('id', $contract_site[$j]->contract_annex_id)->first();
                        $date_expiration = Carbon::create($annexes->date_real)->addMonths($annexes->number_expiration);
                        if ($date_expiration->greaterThan(Carbon::now())) {
                            // contrato activo
                            // get montos
                            $montos = DB::table('contract_payments')->where('contract_annex_id', $contract_site[$j]->contract_annex_id)->first();
                            $collection = $this->get_budget_annex($montos->quantity, $montos->currency_id);
                            $id_annual = DB::table('annual_budgets')->insertGetId([
                                'user_id' => $user,
                                'monto' => $collection->monto,
                                'equipo_activo_monto' => $collection->equipo_activo,
                                'equipo_no_activo_monto' => $collection->equipo_no_activo,
                                'mano_obra_monto' => $collection->mano_obra,
                                'fecha_budget' => '2020-01-01',
                                'estatus' => $status,
                                'moneda_id' => $moneda,
                                'exchange_rate' => $exchange_rate,
                                'id_ubicacion' => $hotels[$i]->id_ubicacion
                            ]);
                            DB::table('sites_budgets')->insert([
                                'hotel_id' => $hotels[$i]->id,
                                'contract_annex_id' => $contract_site[$j]->contract_annex_id,
                                'annual_budget_id' => $id_annual,
                                'user_id' => 2
                            ]);
                            $this->line('Presupuesto insertado');
                        }else{
                            // no insertar nada
                            $this->line('Contrato vencido, no se inserto.');
                        }
                    }
                }else{
                    $this->info('Tiene solo un contrato: ');
                    $annexes = DB::table('contract_annexes')->where('id', $contract_site[0]->contract_annex_id)->first();
                    $date_expiration = Carbon::create($annexes->date_real)->addMonths($annexes->number_expiration);
                    if ($date_expiration->greaterThan(Carbon::now())) {
                        $montos = DB::table('contract_payments')->where('contract_annex_id', $contract_site[0]->contract_annex_id)->first();
                        $collection = $this->get_budget_annex($montos->quantity, $montos->currency_id);

                        $id_annual = DB::table('annual_budgets')->insertGetId([
                            'user_id' => $user,
                            'monto' => $collection->monto,
                            'equipo_activo_monto' => $collection->equipo_activo,
                            'equipo_no_activo_monto' => $collection->equipo_no_activo,
                            'mano_obra_monto' => $collection->mano_obra,
                            'fecha_budget' => '2020-01-01',
                            'estatus' => $status,
                            'moneda_id' => $moneda,
                            'exchange_rate' => $exchange_rate,
                            'id_ubicacion' => $hotels[$i]->id_ubicacion
                        ]);
                        DB::table('sites_budgets')->insert([
                            'hotel_id' => $hotels[$i]->id,
                            'contract_annex_id' => $contract_site[0]->contract_annex_id,
                            'annual_budget_id' => $id_annual,
                            'user_id' => 2
                        ]);
                        $this->line('Presupuesto insertado');
                    }else{
                        // no insertar nada.
                        $this->line('Contrato vencido, no se inserto.');
                    }
                }
            }
        }
        $this->info('Command ended successfuly. iterations: ' . $i);
    }
    public function get_budget_annex($montos, $currency)
    {
        $monto_presupuesto = 0;
        $equipo_activo = 0;
        $equipo_no_activo = 0;
        $mano_obra = 0;
        $object = new stdClass;

        if ($currency == 1) {
            $monto_adolar = (float) ($montos / 19.5); // multiplicado por dolares
            $monto_presupuesto = ($monto_adolar * 0.70);
            $monto_presupuesto = (float)number_format($monto_presupuesto, 2, '.','');
            $equipo_activo = ($monto_presupuesto * 0.70);
            $equipo_no_activo = ($monto_presupuesto * 0.20);
            $mano_obra = ($monto_presupuesto * .10);
        }else{
            $monto_presupuesto = ($montos * 0.70);
            $monto_presupuesto = (float)number_format($monto_presupuesto, 2, '.','');
            $equipo_activo = ($monto_presupuesto * 0.70);
            $equipo_no_activo = ($monto_presupuesto * 0.20);
            $mano_obra = ($monto_presupuesto * .10);
        }
        $object->monto = $monto_presupuesto;
        $object->equipo_activo = $equipo_activo;
        $object->equipo_no_activo = $equipo_no_activo;
        $object->mano_obra = $mano_obra;

        return $object;
    }

    public function handlex() // insercion de annual budgets en base a hotels.
    {
        $res = DB::table('sites_budgets')->get();
        
        $hotels = DB::table('hotels')->get();
        $hotel_count = count($hotels);
        $user = 2; //Esquinca
        $moneda = 2;
        $exchange_rate = 0.00;
        $status = 1;
        // sites_budgets
        // Sitio, Anexo, Annual_id
        for ($i=0; $i < $hotel_count; $i++) {
            $this->info('Current iteration: ' . $i);
            $id_annual = DB::table('annual_budgets')->insertGetId(
                [
                    'user_id' => $user,
                    'fecha_budget' => '2020-01-01',
                    'estatus' => $status,
                    'moneda_id' => $moneda,
                    'exchange_rate' => $exchange_rate
                ]
            );
        }
        // dd($i, $hotel_count);

        $this->info('Command ended successfuly. iterations: ' . $i);  
    }
    public function handle2()
    {
        Date::setLocale('es');
        $date = Date::now()->format('l j F Y H:i:s');
        Log::info('Mi Comando Funciona!');
        $data = [
          'asunto' => 'Test',
          'ip' => 'No hay',
          'hotel' => 'Test',
          'nombre' => 'No disponible',
          'mensaje' => 'Prueba de Task',
          'fecha' => $date
        ];
        Mail::to(['acauich@sitwifi.com', 'jesquinca@sitwifi.com'])->send(new CmdAlerts($data));
    }
    public function handle_ldap()
    {
        $hostname = "ldap.forumsys.com";
        $port = "389";
        // dd($hostname);
        $ldap_conn = ldap_connect($hostname, $port);
        dd($ldap_connect);

    }
    public function handle222() //testing
    {

        //$result = DB::table('contracts_charges_state')->select('id', 'name')->get();
        // $registro = DB::select('CALL payments_fechasolicitud (?, ?)', array('20190101','20190131'));
        // $registro_copy = DB::select('CALL payments_fechasolicitud_copy (?, ?)', array('20190101','20190131'));
        // $registro_2 = DB::select('CALL px_contracts_charges_data (?)', array($date));
        // $registro_3 = DB::select('CALL px_contracts_charges_data_fact (?)', array($date));
        $registro_4 = DB::connection('banks')->select('CALL px_bancos (?)', array($week));

        dd($registro_4);
    }
    public function handleAPI() //prueba NYX API (winhotel)
    {   
        $url_test = 'http://queryapitest.winhotelweb.com/query/PublicQuery/ContactsSummaryRoomDayListQuery';
        $user = 'WiFiNYX';
        $password = 'WFNYX-z123';
        $hotel_code = 'NyxTest';
        $room = "2314";
        $date = "2019-03-10";
        $userID = 'd248c3d9-1e0c-4990-9db8-56d264a5aaad';
        //$array_algo = array('ticket' => array('type' => $type_ticket, 'priority' => $priority_ticket, 'custom_fields' => array(array('id' => 22892328, 'value' => $itcasignado),array('id' => 22881472, 'value' => $name_cliente),array('id' => 22881552, 'value' => $empresa)),'status' => $status, 'tags' => $tags,'comment' => array('body' => $comment, 'public' => $public_b ,'author_id' => $author_id)));
        $query_winhotel = array('QueryCredentials' => array('User' => $user, 'Password' =>  $password, 'UserPasswordToken' => ''), 'QueryRequest' => array('QueryHeader' => array('HotelCodeMap' => array('HotelSourceCode' => $hotel_code, 'HotelTargetCode' => $hotel_code), 'MaxRowsResponse' => 1), 'ContactsRoomDayQueryParameters' => array('Date' => $date, 'RoomCode' => $room), 'UserID' => $userID));      
        //dd($query_winhotel);
        $json = json_encode($query_winhotel);
        $this->info($json);
        $ch = curl_init();
        //echo "Inicializa la funcion .. ";
        curl_setopt($ch, CURLOPT_TIMEOUT, 50);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, false );
        curl_setopt($ch, CURLOPT_MAXREDIRS, 10 );
        curl_setopt($ch, CURLOPT_URL, $url_test);
        //curl_setopt($ch, CURLOPT_USERPWD, "jesquinca@sitwifi.com/token:f4qs3fDR9b9J635IcP6Ce5cGXxKx32ewexk3qmvz");
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-type: application/json'));
        curl_setopt($ch, CURLOPT_USERAGENT, "MozillaXYZ/1.0");

        curl_setopt($ch, CURLOPT_POSTFIELDS, $json);

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 10);

        //echo ".. Termina la funcion ..";
        $output = curl_exec($ch);

        $curlerr = curl_error($ch);
        $curlerrno = curl_errno($ch);

        if ($curlerrno != 0) {
            // Retornar un num de error
            return 0;
        }
        curl_close($ch);
        $decoded = json_decode($output);
        dd($decoded);
    }
    public function handle_correo() // prueba de envio de encuestas en pedazos...
    {
        // Codigo para sentsurvey.
        $data_emails = [];
        $data_insert = [];
        // $fechaini = "2018-04-01";
        // $fechafin = "2018-04-30";
        // $fecha_cur = "2018-04-01";
        // $mesanteriorfull = "2018-03-01";
        $fechaini = date('Y-m-01');
        $fechafin = date('Y-m-t');
        $fecha_cur = date('Y-m');
        $mesanterior = strtotime ( '-1 month' , strtotime ( $fecha_cur ) ) ;
        $mesanterior = date ( 'Y-m' , $mesanterior );
        $mesanteriorfull = $mesanterior . '-01';
        $sql = DB::select('CALL List_User_NPS(?)', array(6));
        $chunks = array_chunk($sql, 70);
        // solucionado realizar 3 comandos y se autoejecutaran seguidamente.
        // dd($chunks, count($chunks), count($sql), count($chunks[0]), $chunks[0][0]->name);

        $this->call('survey:nps1', ['result' => $chunks[0]]);
        $this->info('Command Chunk 1 completed.');
        $this->call('survey:nps1', ['result' => $chunks[1]]);
        $this->info('Command Chunk 2 completed.');
        $this->call('survey:nps1', ['result' => $chunks[2]]);
        $this->info('Command Chunk 3 completed.');


        dd('end?');
        // Codigo para sentsurvey.
        $sql_count = count($sql);
        
        // round();
        // $valores = 178; //179
        // $this->info('Contador:' . $valores);
        // $operation = ($valores / 3);
        // $this->info('divicion:' . $operation);
        // $operation2 = ($operation * 3);
        // $this->info('multi:' . $operation2);
        // encuesta_user id: 9,656
        for ($i=0; $i < 5; $i++) {
            $this->line('Current Iteration: ' . $i);
            $nuevolink = $sql[$i]->id.'/'.'1'.'/'.$mesanteriorfull.'/'.$fechafin;
            $encriptodata= Crypt::encryptString($nuevolink);
            $encriptostatus= Crypt::encryptString('1');

            $data_emails = [
                'nombre' => 'Prueba queues Esquinca',
                'shell_data' => $encriptodata,
                'shell_status' => $encriptostatus
            ];

            $data_insert = [
                'user_id' => $sql[$i]->id,
                'encuesta_id' => 1,
                'estatus_id' => 1,
                'estatus_res' => 0,
                'fecha_inicial' => $fechaini,
                'fecha_corresponde' => $mesanteriorfull,
                'fecha_fin' => $fechafin,
                'shell_data' => $encriptodata,
                'shell_status' => $encriptostatus
            ];

            $this->line('email: ' . $sql[$i]->email);
            $this->line('nombre: ' . $sql[$i]->name);
            // $res = DB::table('encuesta_users')->insert($data_insert);
            // if ($res) {
            //     $this->line('Datos Insertados.');
            // }else{
            //     $this->error('no se insertaron datos.');
            // }
            $this->line('Así quedaria el enlace = http://alice.sitwifi.com/'.$encriptodata.'/'.$encriptostatus);
            // Mail::to($correo)->queue(new Sentsurveynpsmail($data));
            // Mail::to('jesquinca@sitwifi.com')->queue(new Sentsurveynpsmail($data_emails));
            // $this->sentSurveyEmail('jesquinca@sitwifi.com', $data_emails);
        }
        
        //dd($sql);
        $this->info('Command Completed.');
        //dd($sql2);
    }
    public function sentSurveyEmail($correo, $data)
    {
        //$this->line('Current Iteration: ' . $i);
        //dd($data[0]['email']);

        // $data_count = count($data);
        // for ($i=0; $i < $data_count; $i++) {
        //     $nombre = $data[$i]['name'];
        //     $correo = $data[$i]['email'];
        //     $shell1 = $data[$i]['shelldata'];
        //     $shell2= $data[$i]['shellstatus'];

        //     $datos = [
        //         'nombre' => $nombre,
        //         'shell_data' => $shell1,
        //         'shell_status' => $shell2,
        //     ];
            $this->line('Sending Email to: ' . $data['nombre'] . ', ' . $correo);
            //Mail::to('jesquinca@sitwifi.com')->send(new Sentsurveynpsmail($datos));

            $correo = trim($correo);
            Mail::to($correo)->queue(new Sentsurveynpsmail($data));
        //}
    }

    public function getInfoxHab($xml){
        $wsdlloc = "http://api.palaceresorts.com/TigiServiceInterface/ServiceInterface.asmx?wsdl";
        $accion = "http://localhost/xmlschemas/postserviceinterface/16-07-2009/Post_ObtenerInfoRoomPorHabitacion";
        $option=array('trace'=>1);

        try {
            $soapClient = new SoapClient("http://api.palaceresorts.com/TigiServiceInterface/ServiceInterface.asmx?wsdl", $option);

            $resultRequest = $soapClient->__doRequest($xml, $wsdlloc, $accion, 0);

            $soapClient->__last_request = $xml;
            //var_dump($resultRequest);
            //echo "  -REQUEST:\n" . htmlentities($soapClient->__getLastRequest()) . "\n";
            unset($soapClient);
            return $resultRequest;

        } catch (SoapFault $exception) {
            echo "  -REQUEST:\n" . htmlentities($soapClient->__getLastRequest()) . "\n";
            echo $exception->getMessage();
            unset($soapClient);
            return FALSE;
        }
    }

    public function replaceXML($hotelcode, $roominfo){
        $xmlinfo = $this->xmlreq;

        $stringXML = str_replace('xmlns=', 'ns=', $xmlinfo);

        $xmltest = simplexml_load_string($stringXML);

        foreach ($xmltest->xpath('//Rmroom') as $Rmroom) {
            $Rmroom->hotel = $hotelcode;// <---- Agregar la variable dinamica de Hoteles!
            $Rmroom->room = $roominfo; // <---- Aqui es donde va la variable dinamica
        }
        $XMLenString = $xmltest->asXML();
        $XMLreq2 = str_replace('ns=', 'xmlns=', $XMLenString);

        return $XMLreq2;
    }


}
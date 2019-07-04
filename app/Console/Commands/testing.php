<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use DB;

class testing extends Command
{
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
    protected $description = 'Comando para testear funciones.';

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
    public function handle() // test de comprobacion de facturas SAT.
    {
        $emisor="ADC910318AY3";
        $receptor="SIT070918IXA";
        $total="53292.72";
        $uuid="01CF1084-FA9C-49F6-8520-D6AF3081E22E";
        $soap = '<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:tem="http://tempuri.org/"><soapenv:Header/><soapenv:Body><tem:Consulta><tem:expresionImpresa>?re='.$emisor.'&amp;rr='.$receptor.'&amp;tt='.$total.'&amp;id='.$uuid.'</tem:expresionImpresa></tem:Consulta></soapenv:Body></soapenv:Envelope>';
        //encabezados
        $headers = [
            'Content-Type: text/xml;charset=utf-8',
            'SOAPAction: http://tempuri.org/IConsultaCFDIService/Consulta',
            'Content-length: '.strlen($soap)
        ];
        $url = 'https://consultaqr.facturaelectronica.sat.gob.mx/ConsultaCFDIService.svc';

        $datos_send = array($url, $headers, $soap);

        // $this->line('line');
        // $this->error('error');

        $this->info('Datos de respuesta:'); 
        // print_r($datos_send);
        $res = $this->curlZen($datos_send);
        $this->info($res);

        // $XMLresponse = str_replace('xmlns=', 'ns=', $res);
        // print_r($XMLresponse);
        $xml = simplexml_load_string($res);
        // Forma con namespaces.
            // $ns = $xml->getNamespaces(true);
            // print_r($ns);
            // $xml->registerXPathNamespace('s', $ns['s']);
            // $xml->registerXPathNamespace('z', $ns[""]);
            // $xml->registerXPathNamespace('a', $ns['a']);

            // $xml_for = $xml->xpath('//'); // ('a:CodigoEstatus') ('a:EsCancelable') ('a:Estado') variables de la consulta.
            // print_r($xml_for);
            // dd($xml_for);
        // 
        // Funciona forma con children..
            // $data = $xml->children('s', true)->children('', true)->children('', true);
            $data = $xml->children('s', true)->children('', true)->children('', true)->children('a', true);

            $Codigoestatus = $data->CodigoEstatus;
            $Cancelable = $data->EsCancelable;
            $Estado = $data->Estado;

            $this->line('var1: ' . $Codigoestatus);
            $this->line('var2: ' . $Cancelable);
            $this->line('var3: ' . $Estado);

            /*foreach ($data as $variables) {
                print_r($variables);
                $this->info('variables: ' . $variables);
            }*/

            // $data_print = json_encode($data->children('a', true), JSON_UNESCAPED_UNICODE);
            // print_r(json_decode($data_print));
        //
        $this->info('Command ended successfully');
    }
    public function curlZen($data)
    {

        $ch = curl_init();
        //echo "Inicializa la funcion .. ";
        curl_setopt($ch, CURLOPT_URL, $data[0]);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data[2]);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $data[1]);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, false );
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
        return $output;
        // dd($output);
        // $decoded = json_decode($output);
    }

}

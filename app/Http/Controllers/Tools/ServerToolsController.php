<?php

namespace App\Http\Controllers\Tools;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;

use SoapClient;

class ServerToolsController extends Controller
{

public $xmlreq=<<<XML
<?xml version="1.0" encoding="utf-8"?><soap:Envelope xmlns:soap="http://schemas.xmlsoap.org/soap/envelope/" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema"><soap:Body><Post_ObtenerInfoRoomPorHabitacion xmlns="http://localhost/xmlschemas/postserviceinterface/16-07-2009/"><RmroomRequest xmlns="http://localhost/pr_xmlschemas/hotel/01-03-2006/RmroomRequest.xsd"><Rmroom><hotel xmlns="http://localhost/pr_xmlschemas/hotel/01-03-2006/Rmroom.xsd"></hotel><room xmlns="http://localhost/pr_xmlschemas/hotel/01-03-2006/Rmroom.xsd"></room></Rmroom><rooms /></RmroomRequest></Post_ObtenerInfoRoomPorHabitacion></soap:Body></soap:Envelope>
XML;

	/**
	* Show the application server tools
	*
	* @return \Illuminate\Http\Response
	*/

	public function index()
	{
  		return view('permitted.tools.server_tools');
	}


    public function checkRad(Request $request)
    {
        $hotel_code = $request->input('hotelCode');

        if ($hotel_code === 'PL' || $hotel_code === 'CZ') {
            if(DB::connection('sunrisezq')->getDatabaseName()){
                return "TRUE";
            }else{
                return "FALSE";
            }
        }else{
            if(DB::connection('jamaicazq')->getDatabaseName()){
                return "TRUE";
            }else{
                return "FALSE";
            }
        }
    }

    public function checkWB(Request $request)
    {
        $hotel_code = $request->input('hotelCode');

        $XMLquery = $this->replaceXML($hotel_code);
        $XMLresponse = $this->getInfoxHab($XMLquery);
        $XMLresponse = str_replace('xmlns=', 'ns=', $XMLresponse);
        $XMLsimple = simplexml_load_string($XMLresponse);


        foreach ($XMLsimple->xpath('//InfoRoomResponse') as $InfoRoomResponse) {
            $HasError = (string)$InfoRoomResponse->HasErrors;
            $ErrorMSG = (string)$InfoRoomResponse->ExceptionInfo->Message;
        }

        $resultsErr = array(
            "errores" => $HasError,
            "mensaje" => $ErrorMSG
        );

        return $resultsErr;
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

    public function replaceXML($hotelcode){
        $xmlinfo = $this->xmlreq;

        $stringXML = str_replace('xmlns=', 'ns=', $xmlinfo);

        $xmltest = simplexml_load_string($stringXML);

        foreach ($xmltest->xpath('//Rmroom') as $Rmroom) {
            $Rmroom->hotel = $hotelcode;// <---- Agregar la variable dinamica de Hoteles!
            $Rmroom->room = 529; // <---- Aqui es donde va la variable dinamica
        }
        $XMLenString = $xmltest->asXML();
        $XMLreq2 = str_replace('ns=', 'xmlns=', $XMLenString);

        return $XMLreq2;
    }

}

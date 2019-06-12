<?php

namespace App\Http\Controllers\Tools;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use SoapClient;

class GuestToolsController extends Controller
{
public $xmlreq=<<<XML
<?xml version="1.0" encoding="utf-8"?><soap:Envelope xmlns:soap="http://schemas.xmlsoap.org/soap/envelope/" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema"><soap:Body><Post_ObtenerInfoRoomPorHabitacion xmlns="http://localhost/xmlschemas/postserviceinterface/16-07-2009/"><RmroomRequest xmlns="http://localhost/pr_xmlschemas/hotel/01-03-2006/RmroomRequest.xsd"><Rmroom><hotel xmlns="http://localhost/pr_xmlschemas/hotel/01-03-2006/Rmroom.xsd"></hotel><room xmlns="http://localhost/pr_xmlschemas/hotel/01-03-2006/Rmroom.xsd"></room></Rmroom><rooms /></RmroomRequest></Post_ObtenerInfoRoomPorHabitacion></soap:Body></soap:Envelope>
XML;

  /**
  * Show the application guest tools
  *
  * @return \Illuminate\Http\Response
  */
  public function index()
  {
    return view('permitted.tools.guest_tools');
  }

  public function getUsersHC(Request $request)
  {
      $hotel_code = $request->hotelCode;
      $room = $request->roomNum;

      $result = DB::connection('sunrisezq')->table('authtoken')->select([
          'username',
          'name',
          'createdate',
          'expiration',
          'description'
      ])->where([
          ['username', 'like', '%'.$room.'%'],
          ['description', '=', $hotel_code]
      ])->get();

      return $result;
  }

  public function getPortalUsers(Request $request)
  {
      $collection = collect();
      $result1 = DB::connection('sunrisezq')->table('authtoken')->select([
          'username',
          'name',
          'createdate',
          'expiration',
          'description'
      ])->where([
          ['description', '=', 'PL'],
          //['description', '=', 'CZ'],
          //['description', '=', 'ZCJG'],
      ])->get();
      $result2 = DB::connection('sunrisezq')->table('authtoken')->select([
          'username',
          'name',
          'createdate',
          'expiration',
          'description'
      ])->where([
          //['description', '=', 'PL'],
          ['description', '=', 'CZ'],
          //['description', '=', 'ZCJG'],
      ])->get();
      $result3 = DB::connection('sunrisezq')->table('authtoken')->select([
          'username',
          'name',
          'createdate',
          'expiration',
          'description'
      ])->where([
          //['description', '=', 'PL'],
          //['description', '=', 'CZ'],
          ['description', '=', 'ZCJG'],
      ])->get();
      $collection->push($result1);
      $collection->push($result2);
      $collection->push($result3);

      return $collection;
  }

  //deprecated
public function checkGuest(Request $request)
{
  $hotel_code = $request->input('hotelCode');

  $room = $request->input('roomNum');

  if ($hotel_code === 'PL' || $hotel_code === 'CZ') {
      $queryPL = DB::connection('sunrisezq')->table('authtoken')->select([
          'username',
          'createdate',
          'expiration'
      ])->where('username', 'like', '%'.$room.'%')->get();

      return json_encode($queryPL);
  }else{
      $queryJP = DB::connection('jamaicazq')->table('authtoken')->select([
          'username',
          'createdate',
          'expiration'
      ])->where('username', 'like', '%'.$room.'%')->get();

      return json_encode($queryJP);
  }
}

  public function checkWebSer(Request $request)
  {

      $hotel_code = $request->hotelCode;
      $room = $request->roomNum;

      // $hotel_code = 'PL';
      // $room = '445';

      $XMLquery = $this->replaceXML($hotel_code, $room);
      $XMLresponse = $this->getInfoxHab($XMLquery);
      $XMLresponse = str_replace('xmlns=', 'ns=', $XMLresponse);
      $XMLsimple = simplexml_load_string($XMLresponse);


      foreach ($XMLsimple->xpath('//InfoRoomResponse') as $InfoRoomResponse) {
          $HasError = (string)$InfoRoomResponse->HasErrors;
          $ErrorMSG = (string)$InfoRoomResponse->ExceptionInfo->Message;
      }

      if ($HasError == "false") {
          foreach ($XMLsimple->xpath('//RmFolio') as $RmFolio) {
              $ApeXML = (string)$RmFolio->Rmfolio->last_name;
              $NombreXML = (string)$RmFolio->Rmfolio->first_name;
              $nochesXML = (string)$RmFolio->Rmfolio->nights;
              $paisXML = (string)$RmFolio->Rmfolio->country;
              $correoXML = (string)$RmFolio->Rmfolio->mail_name;
          }
          $results = array(
              "errores" => $HasError,
              "apellido" => $ApeXML,
              "nombre" => $NombreXML,
              "pais" => $paisXML,
              "noches" => $nochesXML
          );

          return json_encode($results);
      }else{
          $resultsErr = array(
              "errores" => $HasError,
              "mensaje" => $ErrorMSG
          );

          return json_encode($resultsErr);
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

}

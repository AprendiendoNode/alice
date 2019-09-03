<?php

namespace App\Http\Controllers\Report;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use Auth;
use App\Hotel;
use Carbon\Carbon;
use Jenssegers\Date\Date;
use App\User;

class Capture extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      $user_id = Auth::user()->id;
      $user_role = User::find($user_id)->getRoleNames();
      // return $user_id.'/'.$user_role[0];
      // $hotels = DB::select('CALL px_sitiosXusuario_rol(?, ?)', array($user_id, 'itconcierge'));
      $hotels = DB::select('CALL px_sitiosXusuario_rol(?, ?)', array($user_id, $user_role[0]));
      //$
      return view('permitted.report.individual',compact('hotels'));
    }
    public function upload_client(Request $request)
    {
      // $this->validate($request, [
      //   'phone_client' => 'required | mimes:jpeg,jpg,png'
      // ]);
      $flag = 0;
      $hotel = $request->select_one_type;
      $months = $request->month_upload_type;
      $date = $months.'-01';
      $photo = $request->file('phone_client');

      $find = DB::table('report_hotel_bandas')->where([
            ['hotels_id', '=' , $hotel],
            ['type', '=' , '0'],
            ['Fecha', '=' , $date]
          ])->count();
      if ($find == '0') {
        $almacenar_store = $photo[0]->store('device');
        $result = DB::table('report_hotel_bandas')
        ->insertGetId([
          'hotels_id' => $hotel,
          'Fecha' => $date,
          'img' => $almacenar_store,
          'type' => '0'
        ]);
        if($result != '0'){
          $flag =1;
        }
      }
      return $flag;
    }
    public function upload_banda(Request $request)
    {
      $flag = 0;
      $hotel = $request->select_one_band;
      $months = $request->month_upload_band;
      $date = $months.'-01';
      $photo = $request->file('phone_band');

      $find = DB::table('report_hotel_bandas')->where([
            ['hotels_id', '=' , $hotel],
            ['type', '=' , '1'],
            ['Fecha', '=' , $date]
          ])->count();
      if ($find == '0') {
        $almacenar_store = $photo[0]->store('band');
        $result = DB::table('report_hotel_bandas')
                  ->insertGetId([
                    'hotels_id' => $hotel,
                    'Fecha' => $date,
                    'img' => $almacenar_store,
                    'type' => '1'
                  ]);
        if($result != '0'){
          $flag =1;
        }
      }
      return $flag;
    }

    public function insertGig($data)
    {
      $res = DB::table('gbxdias')->insert($data);

      return $res;
    }

    public function insertUsers($data)
    {
      $res = DB::table('usuariosxdias')->insert($data);

      return $res;
    }

    public function get_zd_hotel(Request $request)
    {
      $select = $request->select;

      $res = DB::select('CALL get_zd_venue(?)', array($select));

      return $res;
    }

    public function upload_gigs(Request $request)
    {
      //Date::setLocale('es');
      $datos = [];
      $operacion = 0;

      $hotelid = (int)$request->select_onet;
      $zdhotel = (int)$request->select_two_zd;
      $date = $request->month_trans_zd;
      $gigas = (int)$request->valorgb_trans;

      $datef = new Date($date);
      $datef = $datef->format('F Y');

      $gigasconvert =  ($gigas * 1000000000);

      if ($zdhotel === 0) {
        $res = DB::table('gbxdias')->where([
          ['hotels_id', '=' , $hotelid],
          ['ZD', '=' , NULL],
          ['Fecha', '=' , $date]
        ])->count();
        $datos = [
          'CantidadBytes' => $gigasconvert,
          'ConsumoReal' => $gigasconvert,
          'Fecha' => $date,
          'Mes' => $datef,
          'hotels_id' => $hotelid,
          'Captura' => 0,
          'days' => 0,
          'updated_at' => Date::now()
        ];
      }else{
        $res = DB::table('gbxdias')->where([
          ['hotels_id', '=' , $hotelid],
          ['ZD', '=' , $zdhotel],
          ['Fecha', '=' , $date]
        ])->count();
        $datos = [
          'CantidadBytes' => $gigasconvert,
          'ConsumoReal' => $gigasconvert,
          'Fecha' => $date,
          'Mes' => $datef,
          'hotels_id' => $hotelid,
          'Captura' => 0,
          'ZD' => $zdhotel,
          'days' => 0,
          'updated_at' => Date::now()
        ];
      }

      if ($res === 0) {
        $operacion = $this->insertGig($datos);
      }else{
        $operacion = 0;
      }

      return (string)$operacion;
    }

    public function upload_users(Request $request)
    {

      $datos = [];
      $operacion = 0;

      $hotelid = (int)$request->select_one_device;
      $date = $request->month_device;
      $users = (int)$request->valor_users;

      $datef = new Date($date);
      $datef = $datef->format('F Y');


      $res = DB::table('usuariosxdias')->where([
        ['hotels_id', '=' , $hotelid],
        ['Fecha', '=' , $date]
      ])->count();

      if ($res === 0) {
        $datos = [
          'NumClientes' => $users,
          'Fecha' => $date,
          'Mes' => $datef,
          'hotels_id' => $hotelid,
          'updated_at' => Date::now()
        ];
        $operacion = $this->insertUsers($datos);
      }else{
        $operacion = 0;
      }

      return (string)$operacion;
    }

    public function upload_comments(Request $request)
    {
      $operacion = 0;

      $hotelid = (int)$request->select_one_comments;
      $months = $request->month_comments;
      $comment = $request->report_comment;

      $date = $months.'-01';

      $record = DB::table('report_comment_months')->where([
        ['hotels_id', '=' , $hotelid],
        ['fecha', '=' , $date]
      ])->count();

      if ($record === 0) {
        $datos = [
          'hotels_id' => $hotelid,
          'fecha' => $date,
          'comentario' => $comment,
          'created_at' => Carbon::now()->toDateTimeString()
        ];
        $operacion = DB::table('report_comment_months')->insert($datos);
      }else{
        $operacion = 0;
      }

      return (string)$operacion;
    }

    public function insertMostAP($data)
    {
      $res = DB::table('mostaps')->insert($data);

      return $res;
    }

    public function upload_mostap(Request $request)
    {
      $datos = [];
      $operacion = 0;

      $hotelid = (int)$request->select_three;
      $date = $request->fecha_aps;

      $datef = new Date($date);
      $datef = $datef->format('F Y');

      $mac1 = $request->mac1;
      $modelo1 = $request->modelo1;
      $cliente1 = $request->cliente1;
      $mac2 = $request->mac2;
      $modelo2 = $request->modelo2;
      $cliente2 = $request->cliente2;
      $mac3 = $request->mac3;
      $modelo3 = $request->modelo3;
      $cliente3 = $request->cliente3;
      $mac4 = $request->mac4;
      $modelo4 = $request->modelo4;
      $cliente4 = $request->cliente4;
      $mac5 = $request->mac5;
      $modelo5 = $request->modelo5;
      $cliente5 = $request->cliente5;

      $res = DB::table('mostaps')->where([
        ['hotels_id', '=', $hotelid],
        ['Fecha', '=', $date]
      ])->count();

      if ($res === 0) {
        $datos = [
          [
            'Fecha' => $date,
            'MAC' => $mac1,
            'NumClientes' => $cliente1,
            'Modelo' => $modelo1,
            'Mes' => $datef,
            'hotels_id' => $hotelid,
            'updated_at' => Date::now()
          ],
          [
            'Fecha' => $date,
            'MAC' => $mac2,
            'NumClientes' => $cliente2,
            'Modelo' => $modelo2,
            'Mes' => $datef,
            'hotels_id' => $hotelid,
            'updated_at' => Date::now()
          ],
          [
            'Fecha' => $date,
            'MAC' => $mac3,
            'NumClientes' => $cliente3,
            'Modelo' => $modelo3,
            'Mes' => $datef,
            'hotels_id' => $hotelid,
            'updated_at' => Date::now()
          ],
          [
            'Fecha' => $date,
            'MAC' => $mac4,
            'NumClientes' => $cliente4,
            'Modelo' => $modelo4,
            'Mes' => $datef,
            'hotels_id' => $hotelid,
            'updated_at' => Date::now()
          ],
          [
            'Fecha' => $date,
            'MAC' => $mac5,
            'NumClientes' => $cliente5,
            'Modelo' => $modelo5,
            'Mes' => $datef,
            'hotels_id' => $hotelid,
            'updated_at' => Date::now()
          ]
        ];
        $operacion = $this->insertMostAP($datos);
      }else{
        $operacion = 0;
      }

      return (string)$operacion;
    }

    public function insertWLAN($data)
    {
      $res = DB::table('wlans')->insert($data);

      return $res;
    }

    public function upload_mostwlan(Request $request)
    {
      $datos = [];
      $operacion = 0;

      $hotelid = (int)$request->select_four;
      $date = $request->fecha_nwlan;

      $datef = new Date($date);
      $datef = $datef->format('F Y');

      $nombrew1 = $request->nombrew1;
      $clientew1 = $request->clientew1;

      $nombrew2 = $request->nombrew2;
      $clientew2 = $request->clientew2;

      $nombrew3 = $request->nombrew3;
      $clientew3 = $request->clientew3;

      $nombrew4 = $request->nombrew4;
      $clientew4 = $request->clientew4;

      $nombrew5 = $request->nombrew5;
      $clientew5 = $request->clientew5;

      $res = DB::table('wlans')->where([
        ['hotels_id', '=', $hotelid],
        ['Fecha', '=', $date]
      ])->count();

      if ($res === 0) {
        array_push($datos, ['NombreWLAN' => $nombrew1,'ClientesWLAN' => $clientew1,'Fecha' => $date, 'Mes' => $datef, 'hotels_id' => $hotelid, 'updated_at' => Date::now()]);
        if (!empty($nombrew2)  && !empty($clientew2) ) {
          array_push($datos, ['NombreWLAN' => $nombrew2, 'ClientesWLAN' => $clientew2, 'Fecha' => $date, 'Mes' => $datef, 'hotels_id' => $hotelid, 'updated_at' => Date::now()]);
        }
        if (!empty($nombrew3)  && !empty($clientew3) ) {
          array_push($datos, ['NombreWLAN' => $nombrew3, 'ClientesWLAN' => $clientew3, 'Fecha' => $date, 'Mes' => $datef, 'hotels_id' => $hotelid, 'updated_at' => Date::now()]);
        }
        if (!empty($nombrew4)  && !empty($clientew4) ) {
          array_push($datos, ['NombreWLAN' => $nombrew4, 'ClientesWLAN' => $clientew4, 'Fecha' => $date, 'Mes' => $datef, 'hotels_id' => $hotelid, 'updated_at' => Date::now()]);
        }
        if (!empty($nombrew5)  && !empty($clientew5) ) {
          array_push($datos, ['NombreWLAN' => $nombrew5, 'ClientesWLAN' => $clientew5, 'Fecha' => $date, 'Mes' => $datef, 'hotels_id' => $hotelid, 'updated_at' => Date::now()]);
        }
        //return $datos;
        $operacion = $this->insertWLAN($datos);
      }else{
        $operacion = 0;
      }

      return (string)$operacion;
    }
}

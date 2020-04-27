<?php

namespace App\Http\Controllers\Hostpots;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;

class Hostpots extends Controller
{
    public function Index()
    {
        return view("hostpots.index");
    }

    public function getRealms()
    {
        $resultSet = DB::select("SELECT id, name as nombre FROM cadenas");
        return response()->json($resultSet);
    }
    
    public function getRealmSites( Request $request )
    {
        $realmID = $request->realmID;
        if( $realmID == 0 ) {
            $resultSet = DB::select("SELECT id,Nombre_hotel as nombre FROM hotels");
        } else {
            $resultSet = DB::select("SELECT id,Nombre_hotel as nombre FROM hotels WHERE cadena_id = ?", [$realmID]);
        }
        return response()->json( $resultSet );
    }

    public function getChartsInfo( Request $request ) {
        $data = base64_decode($request->data);
        $data = json_decode($data);
        $dataset = [];
        switch( intval($data->option) ) {
            case 0:
                foreach( $data->sites as $id) {
                    $resultSet = DB::connection('FreeWifi')->select('CALL get_user_login_day_chain_venue(?, ?, ?,?)',[intval($data->chain), intval($id), $data->dateStart, $data->dateEnd]);
                    array_push($dataset, [
                        'site' => DB::select("SELECT Nombre_hotel as nombre FROM hotels WHERE id = ?", [$id])[0]->nombre,
                        'data' => $resultSet
                    ]);
                }
            break;
            case 1:
                foreach( $data->sites as $id) {
                    $resultSet = DB::connection('FreeWifi')->select('CALL get_unique_user_day_chain_venue(?, ?, ?,?)',[intval($data->chain), intval($id), $data->dateStart, $data->dateEnd]);
                    array_push($dataset, [
                        'site' => DB::select("SELECT Nombre_hotel as nombre FROM hotels WHERE id = ?", [$id])[0]->nombre,
                        'data' => $resultSet
                    ]);
                }
            break;
            case 2: $dataset = []; break;

            case 3: // UPLOAD MB
                foreach( $data->sites as $id) {
                    $resultSet = DB::connection('FreeWifi')->select('CALL get_mb_download_chain_venue(?, ?, ?,?)',[intval($data->chain), intval($id), $data->dateStart, $data->dateEnd]);
                    array_push($dataset, [
                        'site' => DB::select("SELECT Nombre_hotel as nombre FROM hotels WHERE id = ?", [$id])[0]->nombre,
                        'data' => $resultSet
                    ]);
                }
            break;

            case 4: // DOWNLOAD MB
                foreach( $data->sites as $id) {
                    $resultSet = DB::connection('FreeWifi')->select('CALL get_mb_upload_chain_venue(?, ?, ?,?)',[intval($data->chain), intval($id), $data->dateStart, $data->dateEnd]);
                    array_push($dataset, [
                        'site' => DB::select("SELECT Nombre_hotel as nombre FROM hotels WHERE id = ?", [$id])[0]->nombre,
                        'data' => $resultSet
                    ]);
                }
            break;
            case 5: // AVG SESSION DURATION
                foreach( $data->sites as $id) {
                    $resultSet = DB::connection('FreeWifi')->select('CALL get_avg_min_session_chain_venue(?, ?, ?,?)',[intval($data->chain), intval($id), $data->dateStart, $data->dateEnd]);
                    array_push($dataset, [
                        'site' => DB::select("SELECT Nombre_hotel as nombre FROM hotels WHERE id = ?", [$id])[0]->nombre,
                        'data' => $resultSet
                    ]);
                }
            break;
            default: $dataset = []; break;
        }
        return response()->json( $dataset );
    }

}

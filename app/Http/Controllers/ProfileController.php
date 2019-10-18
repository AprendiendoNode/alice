<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Auth;
use Carbon\Carbon;
class ProfileController extends Controller
{
    public function index()
    {
      $userid=Auth::user()->id;
      $isActive=null;
      $isActive = DB::table('model_has_permissions')->where('model_id',$userid)->where('permission_id',216)->count();
      if($isActive==1){
        $estado=true;
      }
      else{
        $estado=false;
      }
      
      return view('permitted.general.profile',compact('estado'));
    }
    public function show(Request $request)
    {
      $resultados = DB::table('users')->select('id', 'name', 'email', 'city')->get();
      return json_encode($resultados);
    }
    public function update(Request $request)
    {
     $id = Auth::user()->id;

     $var_a = $request->inputName;
     $var_b = $request->city;
     if ( !is_null($var_a) && is_null($var_b) )  {
       #cambio todo
       $sql = DB::table('users')->where('id', '=', $id)->update(['name' => $var_a, 'updated_at' => Carbon::now()]);
       // return "#cambio nombre";
       return back()->with('status', 'Name updated!');
     }
     if ( is_null($var_a) && !is_null($var_b) )  {
       #cambio todo
       $sql = DB::table('users')->where('id', '=', $id)->update(['city' => $var_b, 'updated_at' => Carbon::now()]);
       // return "#cambio city";
       return back()->with('status', 'Location updated!');
     }
     if ( !is_null($var_a) && !is_null($var_b) )  {
       #cambio todo
       $sql = DB::table('users')->where('id', '=', $id)->update(['name' => $var_a,'city' => $var_b, 'updated_at' => Carbon::now()]);
       // return "#cambio todo";
       return back()->with('status', 'Profile updated!');
     }
    }

    public function updatepass (Request $request)
    {
     $id = Auth::user()->id;
     $var_a = $request->password;
     $var_b = $request->password_confirmation;
     $encrypt_pass= bcrypt($var_a);

     if ($var_a === $var_b) {
         // return "#cambio password";
         $sql = DB::table('users')->where('id', '=', $id)->update(['password' => $encrypt_pass, 'updated_at' => Carbon::now()]);
         return back()->with('status', 'Password updated!');
     }
     // else { return "#no coinciden password"; }
    }

    public function activeassistant(Request $request){
      $userid=Auth::user()->id;
      $isActive = DB::table('model_has_permissions')->where('model_id',$userid)->where('permission_id',216)->count();
      if($isActive==0){
        DB::table('model_has_permissions')->insert(['model_id'=>$userid,'permission_id'=>216,'model_type'=>'App\User']);
        return 'ok';
      }else{
        return 'no changes';
      }

    }
    public function disableassistant(Request $request){
      $userid=Auth::user()->id;
      $isActive = DB::table('model_has_permissions')->where('model_id',$userid)->where('permission_id',216)->count();
      if($isActive==1){
        DB::table('model_has_permissions')->where('model_id',$userid)->where('permission_id',216)->delete();
        return 'ok';
      }else{
        return 'no changes';
      }

    }

}

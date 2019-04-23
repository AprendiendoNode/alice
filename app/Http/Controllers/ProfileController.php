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
      return view('permitted.general.profile');
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
}

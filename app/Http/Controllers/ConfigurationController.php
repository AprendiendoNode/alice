<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Auth;
use App\User; //Importar el modelo eloquent
use App\Menu; //Importar el modelo eloquent
use Carbon\Carbon;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
class ConfigurationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      $roles = Role::pluck('name', 'id');
      $menus = Menu::pluck('display_name', 'id');
      $permisos = Permission::pluck('name', 'id');

      $union = DB::select('CALL px_permissions_all ()', array());
      $permisosdesarrollo= DB::select('CALL px_permisosSinMenu ()', array());
      $sectionpermit = DB::select('CALL px_seccionsXmenu_permitido ()', array());
      $msect = DB::select('CALL px_seccionsXmenu ()', array());
      $msect_2 = DB::select('CALL px_seccionsXmenu_2 ()', array());

      return view('permitted.admin.configuration', compact('roles', 'menus', 'permisos', 'union', 'permisosdesarrollo', 'sectionpermit','msect_2'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
     public function create(Request $request)
     {
         if (auth()->user()->can('Create user')) {
           $name= $request->inputCreatName;
           $email= $request->inputCreatEmail;
           $city= $request->inputCreatLocation;
           $role= $request->selectCreatRole;

           $new_user = new User;
           $new_user->name=$name;
           $new_user->email=$email;
           $new_user->password= bcrypt('123456');
           $new_user->city=$city;
           $new_user->save();
           $new_user->assignRole($role);

           return 'true';
         }
         else {
           return 'false';
         }
     }
    public function update_index3(Request $request)
    {
      $menus_act = false;
      $permisos_act = false;
      $id_usuario_recibido = $request->identificador;

      if (auth()->user()->id == $id_usuario_recibido) { //View Configuration
        if ( empty ( $request->permissions ) || empty ( $request->menu ) ) {
          return 'abort';
        }
        else {
          if ( !empty ( $request->permissions ) ) {
            if (in_array("View Configuration", $request->permissions)) { //Comprobamos que traiga minimo el permiso de View Configuration
              $user = User::find($request->identificador);
              $user->permissions()->detach(); //Method of eloquent remove all
              $user->syncPermissions($request->permissions);
            }
            else {
              return 'uncompleted';//Si selecciono pero no trajo la opcion de View Configuration
            }
          }
          if (!empty ( $request->menu ) ) {
              $user = User::find($request->identificador);
              $user->menus()->detach(); //Method of eloquent remove all
              $user->menus()->sync($request->menu);
          }
          return 'complete';
        }
      }
      else { //No es el usuario actual
        $user = User::find($request->identificador);
        $user->permissions()->detach(); //Method of eloquent remove all
        $user->menus()->detach(); //Method of eloquent remove all
        $user->syncPermissions($request->permissions);
        $user->menus()->sync($request->menu);
        return 'complete_two';
      }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
     public function store(Request $request)
     {
       if (auth()->user()->can('Edit user')) {
         $id = $request->sector;
         $user = User::find($id);
         if(!empty($user)){
           $user->getRoleNames();
           return $user;
         }
         else{
           return '';
         }
       }
       else {
         return '';
       }
     }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
      $result = DB::select('CALL GetAllUserConfiguration ()', array());
      return json_encode($result);
    }
    public function showMenu(Request $request)
    {
      $id = $request->sector;
      $bar = User::find($id);

      if(!empty($bar)){
        $bar->permissions;
        $bar->menus;
        return $bar;
      }
      else {
        return 'abort';
      }
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
     public function edit(Request $request)
     {
       if (auth()->user()->can('Edit user')) {
         $name= $request->inputEditName;
         $email= $request->inputEditEmail;
         $city= $request->inpuEditlocation;
         $priv= $request->selectEditPriv;

         $user = User::where('email',$email) -> first();
         $user->name = $name;
         $user->city = $city;
         $user->save();
         $user->syncRoles($priv);
         return 'true';
       }
       else {
         return 'false';
       }
     }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
      if (auth()->user()->can('Delete user')) {
        if (auth()->user()->id == $request->identificador) {
          return 'abort';
        }
        else{
          $id_user = $request->identificador;
          $user = User::find($id_user);
          if(!empty($user)){
            $user->menus()->detach(); //Method of eloquent remove all
            $user->delete(); //Method of eloquent remove user
            return 'true';
          }
          else{
            return 'abort';
          }
        }
      }
      else {
        return 'false';
      }
    }
}

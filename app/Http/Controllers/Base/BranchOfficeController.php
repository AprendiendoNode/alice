<?php

namespace App\Http\Controllers\Base;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Base\BranchOffice;
use \Carbon\Carbon;
use Auth;
use DB;

class BranchOfficeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      $countries = DB::select('CALL GetAllCountryActivev2 ()', array());
      $states = DB::select('CALL GetAllStateActivev2 ()', array());
      $cities = DB::select('CALL GetAllCitiesv2 ()', array());

      return view('permitted.base.branch_office',compact('countries', 'states', 'cities'));
    }

    public function getAllBranchOffice()
    {
      $result = DB::select('CALL px_branch_offices_all()', array());

      return $result;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $newbranch = new BranchOffice;
        $newbranch->name = $request->inputCreateName;
        $newbranch->email = $request->inputCreatEmail;
        $newbranch->phone = $request->inputCreatPhone;
        $newbranch->phone_mobile = $request->inputCreatPhoneMobile;
        $newbranch->address_1 = $request->inputCreatAddress_1;
        $newbranch->address_2 = $request->inputCreatAddress_2;
        $newbranch->address_3 = $request->inputCreatAddress_3;
        $newbranch->address_4 = $request->inputCreatAddress_4;
        $newbranch->address_5 = $request->inputCreatAddress_5;
        $newbranch->address_6 = $request->inputCreatAddress_6;
        $newbranch->city_id = $request->select_ciudades;
        $newbranch->state_id = $request->select_estados;
        $newbranch->country_id = $request->select_paises;
        $newbranch->postcode = $request->inputZipCode;
        $newbranch->comment = $request->datainfo;
        $newbranch->sort_order = $request->inputCreatOrden;
        $newbranch->status = $request->status;
        $newbranch->created_uid = 1;
        $newbranch->updated_uid = 1;
        $newbranch->created_at = Carbon::now();
        $newbranch->save();

        return response()->json(["status" => 200]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request)
    {
        $result = DB::select('CALL px_branch_offices_xid(?)', array($request->id));

        return $result;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
      $user_id = Auth::id();
      $status= !empty($request->statusEdit) ? 1 : 0;

      $setbranch = BranchOffice::find($request->id_branch);
      $setbranch->name = $request->inputEditName;
      $setbranch->email = $request->inputEditEmail;
      $setbranch->phone = $request->inputEditPhone;
      $setbranch->phone_mobile = $request->inputEditPhoneMobile;
      $setbranch->address_1 = $request->inputEditAddress_1;
      $setbranch->address_2 = $request->inputEditAddress_2;
      $setbranch->address_3 = $request->inputEditAddress_3;
      $setbranch->address_4 = $request->inputEditAddress_4;
      $setbranch->address_5 = $request->inputEditAddress_5;
      $setbranch->address_6 = $request->inputEditAddress_6;
      $setbranch->city_id = $request->select_ciudades_edit;
      $setbranch->state_id = $request->select_estados_edit;
      $setbranch->country_id = $request->select_paises_edit;
      $setbranch->postcode = $request->inputZipCodeEdit;
      $setbranch->comment = $request->datainfoEdit;
      $setbranch->sort_order = $request->inputEditOrden;
      $setbranch->status = $status;
      $setbranch->updated_uid = $user_id;
      $setbranch->updated_at = Carbon::now();
      $setbranch->save();

      return response()->json(["status" => 200]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}

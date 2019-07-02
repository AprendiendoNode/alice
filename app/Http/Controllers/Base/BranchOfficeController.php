<?php

namespace App\Http\Controllers\Base;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Base\BranchOffice;
use \Carbon\Carbon;
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
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
    public function destroy($id)
    {
        //
    }
}

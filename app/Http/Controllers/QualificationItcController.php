<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Auth;
use Carbon\Carbon;
class QualificationItcController extends Controller
{
    public function index()
    {   
        $itc = DB::select('CALL px_ITC_todos()', array());

        
        
        return view('permitted.qualification.qualification_itc', compact('itc'));
    }

    
    

}

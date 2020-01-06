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
    
      return view('permitted.qualification.qualification_itc');
    }

    
    

}

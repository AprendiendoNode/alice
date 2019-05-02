<?php

namespace App\Http\Controllers\Base;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DashboardCFDIController extends Controller
{
  public function dashboard()
  {
    return view('permitted.invoicing.dashboard_cfdi');
  }
  public function settings_pac()
  {
    return view('permitted.invoicing.settings_pac');
  }
  public function store(Request $request)
  {
      //
  }
}

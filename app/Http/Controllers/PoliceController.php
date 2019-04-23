<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PoliceController extends Controller
{
  public function index()
  {
      return view('auth.policies');
  }
}

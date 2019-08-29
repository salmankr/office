<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class logsDataController extends Controller
{
    public function index(){
    	return view('custom.logs');
    }
}

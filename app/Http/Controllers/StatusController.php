<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class StatusController extends Controller
{
    //
    public function index()
    {
        return "ok";
        return view('complain_status');
    }
}

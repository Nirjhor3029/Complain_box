<?php

namespace App\Http\Controllers;

use App\Idea;
use App\Upload;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Events\NewIdeaChannel;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
// use File;



class ComplainController extends Controller
{

	//
	public function __construct()
    {
		$this->middleware(['web']);
	}



}

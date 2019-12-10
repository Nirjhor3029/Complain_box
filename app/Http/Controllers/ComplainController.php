<?php

namespace App\Http\Controllers;

use App\Idea;
use App\Upload;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Events\NewIdeaChannel;
use App\Status;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Str;

// use File;


class ComplainController extends Controller
{

    //
    public function __construct()
    {
        $this->middleware(['web']);
    }

    public function search(Request $request)
    {
        $check = 0;
        $status = Status::orderBy('priority')->get();

        if (isset($request->complain_id)) {
            $check = 1;
            $complain = Idea::where('contact', $request->mobile)->where('complain_id', $request->complain_id)->first();

        } else {
            $check = 0;
            $complains = Idea::where('contact', $request->mobile)->get();
        }


        return view('complain_status', compact('complain', 'status', 'check', 'complains'));
    }

    public function searchById($complain_id)
    {
        $check = 1;
        $status = Status::orderBy('priority')->get();

        $complain = Idea::where('complain_id', $complain_id)->with('user')->first();
        // return $complain;

        $complains = Idea::where('contact', $complain->contact)->get();

        return view('complain_status', compact('complain', 'status', 'check', 'complains'));


    }
}

<?php

namespace App\Http\Controllers;

use App\Idea;
use App\Role;
use App\Status;
use Carbon\Carbon;
use Illuminate\Http\Request;

class StatusController extends Controller
{
	//
	public function index()
	{
		$statuses = Status::orderBy('priority')->paginate(25);
		return view('admin-dashboard.complain_status', compact('roles', 'statuses'));
	}

	public function create()
	{
		$statuses = Status::orderBy('priority')->paginate(25);
		$create = 1;
		$max_status_priority = Status::max('priority');
		$max_status_priority++;
		return view('admin-dashboard.complain_status', compact('statuses', 'create', 'max_status_priority'));
	}
	public function create_submit(Request $request)
	{
		$status = new Status();
		$status->title = strtolower($request->title);
		$status->priority = $request->priority;
		$status->save();

		laraflash()->message('New Status (' . $status->title . ') Added !!' . Carbon::now()->format('F j, Y, g:i A'))->success();

		$statuses = Status::orderBy('priority')->paginate(25);
		$create = 1;
		$max_status_priority = Status::max('priority');
		$max_status_priority++;
		return view('admin-dashboard.complain_status', compact('statuses', 'create', 'max_status_priority'));
		// return redirect()->route('admin.admin-allStatus');
	}

	public function edit($status_id)
	{
		$statuses = Status::orderBy('id')->paginate(25);
		return view('admin-dashboard.complain_status', compact('statuses', 'status_id'));
	}
	public function edit_submit(Request $request, $status_id)
	{
		$status = Status::find($status_id);
		laraflash()->message('Status (' . $status->title . '::' . $status->priority . ') Update by (' . $request->title . ':: ' . $request->priority . ') !! ' . Carbon::now()->format('F j, Y, g:i A'))->success();
		$status->title = strtolower($request->title);
		$status->priority = $request->priority;
		$status->save();
		return redirect()->route('admin.admin-allStatus');
	}
	public function delete($status_id)
	{
		// return "deleted";
		$status = Status::find($status_id);
		laraflash()->message($status->title . ' : Status Deleted !!' . Carbon::now()->format('F j, Y, g:i A'))->success();
		$status->delete();


		return redirect()->route('admin.admin-allStatus');
	}

	public function status_change($complain_id,$status_id)
	{

		$complain = Idea::find($complain_id);
		$complain->status = $status_id;
		$complain->save();
		laraflash()->message($complain->title . ' : Status Changed !!' . Carbon::now()->format('F j, Y, g:i A'))->success();
		return redirect()->back();
	}
}
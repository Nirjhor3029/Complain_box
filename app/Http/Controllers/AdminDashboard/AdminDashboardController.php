<?php

namespace App\Http\Controllers\AdminDashboard;

use App\Charts\IdeaChart;
use App\Http\Controllers\Controller;
use App\Idea;
use App\Status;
use Carbon\Carbon;
use Illuminate\Http\Request;

class AdminDashboardController extends Controller
{
	public function __construct()
	{
		$this->middleware(['role:super_administrator|administrator|moderator|maintainer', 'web', 'auth', 'isActive',]);
	}

	/**
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
	public function adminDashboard()
	{

		$featuredIdeasCount = Idea::orderByDesc('updated_at')->whereUserId(auth()->id())->whereIsActive(1)->whereIsSubmitted(1)->whereIsApproved(1)->whereIsFeatured(1)->count();

		$submittedIdeasCount = Idea::orderByDesc('updated_at')->whereUserId(auth()->id())->whereIsActive(1)->whereIsSubmitted(1)->count();

		$recentIdeasCount = Idea::orderByDesc('created_at')->whereIsActive(1)->whereIsSubmitted(1)->whereMonth('submitted_at', date('m'))->count();

		/**
		 * Generating data for Idea Received Ratio Chart
		 */
		$dateStarts = Carbon::now()->startOfMonth()->subMonths(6);
		$dateEnds = Carbon::now()->startOfMonth();

		$data = Idea::whereIsActive(1)->whereIsSubmitted(1)->orderBy('created_at')->whereBetween(
			'created_at',
			[$dateStarts, $dateEnds]
		)->get()->groupBy(static function ($itemGroupBy) {
			return Carbon::parse($itemGroupBy->created_at)->format('M-y');
		});

		$data = $data->map(static function ($item) {
			return count($item);
		});

		$ideasChart = new IdeaChart();
		$ideasChart->labels($data->keys());
		$ideasChart->dataset('Idea Received', 'line', $data->values())->color('rgb(255, 196, 0)')->backgroundcolor('transparent');

		return view('admin-dashboard.index', compact('featuredIdeasCount', 'submittedIdeasCount', 'recentIdeasCount', 'ideasChart'));
	}
	public function previousMontIdeas()
	{
		$idea_name = "Previous Month Ideas";
		$previous_month = date('m') - 1;
		// return $previous_month;
		$ideasCount = Idea::orderByDesc('created_at')->whereIsActive(1)->whereIsSubmitted(1)->whereMonth('submitted_at', $previous_month)->count();
		return view('admin-dashboard.previous_ideas', compact('ideasCount', 'idea_name'));
	}
	public function featuredIdeas()
	{
		$idea_name = "Featured Ideas";
		$ideasCount = Idea::orderByDesc('created_at')->whereIsActive(1)->whereIsSubmitted(1)->whereIsFeatured(1)->count();
		return view('admin-dashboard.featured_ideas', compact('ideasCount', 'idea_name'));
	}
	public function allIdeas()
	{
		$idea_name = "All Ideas";
		$ideasCount = Idea::orderByDesc('created_at')->count();
		$all_idea_published = Idea::orderByDesc('created_at')->whereIsActive(1)->whereIsSubmitted(1)->count();

		$publishedIdeas = Idea::with('user', 'comments', 'likes')->orderByDesc('submitted_at')->whereIsActive(1)->whereIsSubmitted(1)->get();

		$statuses = Status::orderBy('priority')->get();
		//return $statuses;

		//return $publishedIdeas;
		return view('admin-dashboard.all_ideas', compact('ideasCount', 'idea_name', 'all_idea_published', 'publishedIdeas', 'statuses'));
	}

	public function makeFeatured(Request $request)
	{
		$ideaId =  $request->idea_id;
		$idea = Idea::find($ideaId);
		$idea->is_featured = 1;
		$idea->is_approved = 1;
		$idea->is_active = 1;
		$idea->save();
		return response(['idea', $idea], 201);
	}
	public function makeNonFeatured(Request $request)
	{
		$ideaId =  $request->idea_id;
		$idea = Idea::find($ideaId);
		$idea->is_featured = 0;
		$idea->save();
		return response(['idea', $idea], 201);
	}
}
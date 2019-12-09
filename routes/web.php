<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('/php-artisan-storage-link', function () {
//     Artisan::call('storage:link');
// });

use App\Idea;
use App\Upload;
use Illuminate\Http\Request;

Route::get('/', function () {
    return view('welcome');
});
Route::prefix('secure/auth')->name('account.')->group(static function () {
    Auth::routes(['register' => false]);
});

Route::prefix('2fa')->name('two_factor_authentication.')->middleware(['web', 'auth', 'isActive'])->group(static function () {
    Route::get('/', 'TwoFactorAuthenticationController@index')->name('index');
    Route::post('/', 'TwoFactorAuthenticationController@store')->name('store');
});

Route::prefix('secure/dashboard')->name('dashboard.')->middleware([
    'web', 'auth', 'isActive', 'acceptTNC',
])->group(static function () {

    Route::middleware('two_factor_authentication')->group(static function () {
        Route::get('/', 'AccountDashboardController@index')->name('index');
        Route::get('/how-it-works', 'AccountDashboardController@howItWorks')->name('how-it-works');
        Route::get('/all-idea', 'AccountDashboardController@allIdeas')->name('all-idea');
        Route::get('/featured-ideas', 'AccountDashboardController@featuredIdeas')->name('featured-ideas');

        Route::resource('role', 'RoleController');
        Route::resource('permission', 'PermissionController');
        Route::resource('user', 'UserController');
        Route::resource('idea', 'IdeaController');
    });

    /**FILE UPLOAD */
    Route::post('/file-upload', 'UploadController@storeUpload')->name("file-upload");

    Route::post('upload-file-delete', 'UploadController@delete_uploads_files')->name('upload-file-delete');

    Route::post('broadcast-new-idea', 'IdeaController@broadcastChannel');

    Route::get('/individual-idea-published-comments', static function () {
        return Idea::with('comments', 'comments.user', 'likes', 'ratings', 'avgRating')->whereUuid(request()->get('ideaUuid'))->first();
    });

    Route::get('/recent-idea-published', static function () {
        $recentIdeas = Idea::with('user', 'comments', 'likes')->whereIsActive(1)->whereIsSubmitted(1)->orderByDesc('submitted_at')->whereMonth(
            'submitted_at',
            date('m')
        )->get();

        return response()->json(['ideas' => $recentIdeas]);
    });

    Route::get('/all-ideas-published', static function () {
        $publishedIdeas = Idea::with('user', 'comments', 'likes')->orderByDesc('submitted_at')->whereIsActive(1)->whereIsSubmitted(1)->get();

        return response()->json(['ideas' => $publishedIdeas]);
    });
    Route::get('/all-ideas', static function () {
        $publishedIdeas = Idea::with('user', 'comments', 'likes')->orderByDesc('submitted_at')->get();

        return response()->json(['ideas' => $publishedIdeas]);
    });

    Route::get('/previous-ideas-published', static function () {
        $previous_month = date('m') - 1;
        $publishedIdeas = Idea::with(
            'user',
            'comments',
            'likes'
        )->orderByDesc('submitted_at')->whereIsActive(1)->whereIsSubmitted(1)->whereMonth('submitted_at', $previous_month)->get();

        return response()->json(['ideas' => $publishedIdeas]);
    });

    Route::get('/all-featured-ideas-published', static function () {
        $featuredIdeas = Idea::with(
            'user',
            'comments',
            'likes'
        )->orderByDesc('submitted_at')->whereIsActive(1)->whereIsSubmitted(1)->whereIsApproved(1)->whereIsFeatured(1)->get();

        return response()->json(['ideas' => $featuredIdeas]);
    });

    Route::get('my-drafted-ideas', 'IdeaController@draftedIdeas')->name('my-drafted-ideas');
    Route::get('my-featured-ideas', 'IdeaController@featuredIdeas')->name('my-featured-ideas');

    Route::get('/mySubmitted-idea-published', static function () {
        $submittedIdeas = Idea::orderByDesc('updated_at')->whereUserId(auth()->id())->whereIsActive(1)->whereIsSubmitted(1)->with('likes')->get();

        return response()->json(['ideas' => $submittedIdeas]);
    });


    Route::get('/mySubmitted-idea-published', static function () {
        $submittedIdeas = Idea::orderByDesc('updated_at')->whereUserId(auth()->id())->whereIsActive(1)->whereIsSubmitted(1)->with('likes')->get();

        return response()->json(['ideas' => $submittedIdeas]);
    });

    //Route::resource('upload', 'UploadController');
    Route::delete('upload/{upload}', 'UploadController@destroy')->name('upload.destroy');

    Route::post('new-comment', 'CommentController@store')->name('submit-new-comment');
    Route::post('delete-comment', 'CommentController@delete')->name('delete-comment');
    Route::post('edit-comment', 'CommentController@edit')->name('edit-comment');
    Route::post('update-comment', 'CommentController@update')->name('update-comment');

    Route::post('submit-like', 'LikeController@store');

    /**
     * Idea Rating
     */
    Route::post('idea-rating', static function (Request $request) {
        $idea = Idea::whereUuid($request->get('idea_id'))->firstOrFail();

        $rating = \App\Rating::whereRateableId($idea->id)->whereUserId(auth()->id())->first();

        if (!$rating) {
            $rating = new \App\Rating();
            $rating->rating = $request->get('rating') ?: 0;
            $rating->user_id = auth()->id();

            $idea->ratings()->save($rating);

            return $rating;
        }

        $rating->update([
            $rating->rating = $request->get('rating') ?: 0,
        ]);

        return $rating;
    });

    Route::get('my-profile', 'AccountDashboardController@myProfile')->name('my-profile');
    Route::get('my-profile/update', 'AccountDashboardController@updateMyProfile')->name('update-my-profile');
    Route::post('my-profile/update/submit', 'AccountDashboardController@updateMyProfileForm')->name('update-my-profile-form');


    /**Filtering Data */

    Route::post('/filter-all-ideas-published', static function (Request $data) {

        /**When Date and topic is given */
        if ($data->start != null && $data->end != null && $data->topic != '') {
            $from = date('Y-m-d', strtotime($data->start));
            $to = date('Y-m-d', strtotime($data->end));
            // return response()->json(['ideas' => [$from, date('Y-m-d', strtotime($data->end))]]);

            $featuredIdeas = Idea::with(
                'user',
                'comments',
                'likes'
            )->orderByDesc('submitted_at')
                ->whereIsSubmitted(1)
                ->whereBetween('submitted_at', [$from, $to])
                ->where('topic', $data->topic)->get();
            /**Filter By Date only*/
        } elseif ($data->start != null && $data->end != null && $data->topic == '') {

            $from = date('Y-m-d', strtotime($data->start));
            $to = date('Y-m-d', strtotime($data->end));

            $featuredIdeas = Idea::with(
                'user',
                'comments',
                'likes'
            )->orderByDesc('submitted_at')
                ->whereIsSubmitted(1)
                ->whereBetween('submitted_at', [$from, $to])->get();
            /**Filter By Topic only */
        } elseif ($data->start == null && $data->end == null && $data->topic != '') {
            $featuredIdeas = Idea::with(
                'user',
                'comments',
                'likes'
            )->orderByDesc('submitted_at')
                ->whereIsSubmitted(1)
                ->where('topic', $data->topic)->get();
        }

        return response()->json(['ideas' => $featuredIdeas]);
    });

    Route::post('/filter-all-featured-ideas-published', static function (Request $data) {

        /**When Date and topic is given */
        if ($data->start != null && $data->end != null && $data->topic != '') {
            $from = date('Y-m-d', strtotime($data->start));
            $to = date('Y-m-d', strtotime($data->end));
            // return response()->json(['ideas' => [$from, date('Y-m-d', strtotime($data->end))]]);

            $featuredIdeas = Idea::with(
                'user',
                'comments',
                'likes'
            )->orderByDesc('submitted_at')
                ->whereIsActive(1)
                ->whereIsSubmitted(1)
                ->whereIsApproved(1)
                ->whereIsFeatured(1)
                ->whereBetween('submitted_at', [$from, $to])
                ->where('topic', $data->topic)->get();
            /**Filter By Date only*/
        } elseif ($data->start != null && $data->end != null && $data->topic == '') {

            $from = date('Y-m-d', strtotime($data->start));
            $to = date('Y-m-d', strtotime($data->end));

            $featuredIdeas = Idea::with(
                'user',
                'comments',
                'likes'
            )->orderByDesc('submitted_at')
                ->whereIsActive(1)
                ->whereIsSubmitted(1)
                ->whereIsApproved(1)
                ->whereIsFeatured(1)
                ->whereBetween('submitted_at', [$from, $to])->get();
            /**Filter By Topic only */
        } elseif ($data->start == null && $data->end == null && $data->topic != '') {
            $featuredIdeas = Idea::with(
                'user',
                'comments',
                'likes'
            )->orderByDesc('submitted_at')
                ->whereIsActive(1)
                ->whereIsSubmitted(1)
                ->whereIsApproved(1)
                ->whereIsFeatured(1)
                ->where('topic', $data->topic)->get();
        }

        return response()->json(['ideas' => $featuredIdeas]);
    });
});

Route::prefix('secure/admin')->name('admin.')->middleware([
    'web', 'auth', 'isActive', 'acceptTNC', 'two_factor_authentication', 'role:super_administrator|administrator|moderator|maintainer',
])->group(static function () {

    Route::get('/', 'AdminDashboard\AdminDashboardController@adminDashboard')->name('admin-dashboard');
    Route::get('/previousMontIdeas', 'AdminDashboard\AdminDashboardController@previousMontIdeas')->name('admin-previousMontIdeas');
    Route::get('/featuredIdeas', 'AdminDashboard\AdminDashboardController@featuredIdeas')->name('admin-featuredIdeas');
    Route::get('/allIdeas', 'AdminDashboard\AdminDashboardController@allIdeas')->name('admin-allIdeas');
    Route::post('/make_featured', 'AdminDashboard\AdminDashboardController@makeFeatured')->name('admin-makeFeatured');
    Route::post('/make_non_featured', 'AdminDashboard\AdminDashboardController@makeNonFeatured')->name('admin-makeNonFeatured');
});

Route::prefix('terms')->name('terms.')->group(static function () {
    Route::get('/', 'AccountDashboardController@acceptTermsAndConditions')->name('show');
    Route::post('/', 'AccountDashboardController@confirmTermsAndConditions')->name('update');
});

Route::group([
    'prefix' => 'file-manager',
    'middleware' => ['web', 'auth', 'isActive', 'acceptTNC', 'two_factor_authentication'],
], static function () {
    UniSharp\LaravelFilemanager\Lfm::routes();
});

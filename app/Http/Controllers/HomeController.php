<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $friends = FriendController::friendListHelperPaginate($request)[0];
        $friendRequestsReceived = FriendController::friendListHelper($request)[1];
        $courses = CourseController::courseListHelper($request);

        return view('home', ['courses' => $courses, 'friends' => $friends,
            'friendRequestsReceived' => $friendRequestsReceived]);
    }
}

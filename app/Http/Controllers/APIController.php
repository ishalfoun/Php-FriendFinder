<?php

namespace App\Http\Controllers;

use App\User;
use App\Course;
use App\
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class APIController extends Controller {
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function allFriends(Request $request){
        $credentials = $request->only('email','password');
        $valid = Auth::once($credentials);
        if (!$valid)
            return $response()->json(['error' => 'invalid credentials'],401);
        else {
            $friends = null; //MAKE IT RETREIVE DATA
            return $respone()->json($friends,200)
        }
    }

    public function breakFriends(Request $request){
        $credentials = $request->only('email','password');
        $valid = Auth::once($credentials);
        if (!$valid)
            return $response()->json(['error' => 'invalid credentials'],401);
        else {
            $day = $request->input('day');
            $start = $request->input('start');
            $end = $request->input('end');
            if ($day == null || !($day > 0 && $day <31) || $start = null || !($start > 0 && $start < 1440 ) || $end == null || !($end < $start && $end > 0 && $end < 1440 )){
                return $response()->json(['error' => 'bad or missing parameter'],400);
            }
            else {
                $friends = null; //CHANGE TO GET FRIENDS
                return $response()->json($friends,200);
            }
        }
    }

    public function courseFriends(Request $request){
        $credentials = $request->only('email','password');
        $valid = Auth::once($credentials);
        if (!$valid)
            return $response()->json(['error' => 'invalid credentials'],401);
        else {
            $coursename = $request->input('coursename');
            $section = $request->input('section');
            if ($coursename == null || $section = null){
                return $response()->json(['error' => 'bad or missing parameter'],400);
            }
            else {
                $friends = null; //CHANGE TO GET FRIENDS
                return $response()->json($friends,200);
            }
        }
    }

    public function whereIsFriend(Request $request){
        $credentials = $request->only('email','password');
        $valid = Auth::once($credentials);
        if (!$valid)
            return $response()->json(['error' => 'invalid credentials'],401);
        else {
            $friendemail = $request->input('coursename');
            $day = $request->input('section');
            $time = $request->input('time');
            if ($coursename == null || $section = null $time == null !($time > 0 && $time < 1440 ) ){
                return $response()->json(['error' => 'bad or missing parameter'],400);
            }
            else if (false){//CHANGE TO IF NOT FRIEND
                return $response()->json(['error' => 'not friend'],400);
            }
            else {
                $course = null; //CHANGE TO GET COURSE
                return $response()->json($course,200);
            }
        } 
    }
}
<?php

namespace App\Http\Controllers;

use App\Course;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class CourseController extends Controller
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
     * Display a list of all of the user's courses.
     *
     * @param  Request  $request
     * @return Response
     */
    public function index(Request $request)
    {
        $courses = $request->user()->courses()->get();
        return view('courses.index', ['courses' => $courses, 'found'=>null]);
    }

    /**
     * Search Courses
     *
     * @param  Request  $request
     * @return Response
     */
    public function search(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|max:255',
        ]);

        $searchkey = $request->name;

        $courses = Course
            ::where('title', 'LIKE', "%$searchkey%")
            ->simplePaginate(20);

        return  view('courses.result', ['courses' => $courses, 'key'=>$searchkey]);

//        echo 'searching for: '.$searchkey;
//        if ($found) {
//            echo 'found: ' . $found->title;
//        }
//        else
//            echo 'not found';

    }


    /**
     * Register for a course
     *
     * @param  Request  $request
     * @param  Task  $task
     * @return Response
     */
    public function register(Request $request, Course $course)
    {
        //get which id he clicked
        //make netry in course_user with both user id and course id

        DB::table('course_user')->insert([
            'course_id' => $course->id,
            'user_id' => \Auth::user()->id,
        ]);
    }



    /**
     * Drop a course
     *
     * @param  Request  $request
     * @param  Task  $task
     * @return Response
     */
    public function drop(Request $request, Course $course)
    {
        //TODO: implement delete code here
    }



//    /**
//     * Create a new task.
//     *
//     * @param  Request  $request
//     * @return Response
//     */
//    public function store(Request $request)
//    {
//        $this->validate($request, [
//            'name' => 'required|max:255',
//        ]);
//
//        $request->user()->tasks()->create([
//            'name' => $request->name,
//        ]);
//
//    }

}

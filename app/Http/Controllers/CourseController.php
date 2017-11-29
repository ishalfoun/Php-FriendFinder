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

        //is this a request for the next page? (pagination)
        if($request->has('page') && $request->has('searchKey')){

            $searchKey = strtolower($request->searchKey);

            $courses = Course::where('title', 'ILIKE', '%' . $searchKey . '%')->simplePaginate(20);

            return  view('courses.result', ['courses' => $courses, 'key'=>$searchKey]);

        }else{
            //otherwise, show first page of results
            $this->validate($request, [
                'searchKey' => 'required|max:255',
            ]);

            $searchKey = strtolower($request->searchKey);

            $courses = Course
                ::where('title', 'ILIKE', '%' . $searchKey . '%')->simplePaginate(20);

            return  view('courses.result', ['courses' => $courses, 'key'=>$searchKey]);

        }


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
        $request->user()->courses()->attach($course->id);

        return redirect()->action('CourseController@index');
    }

    /**
     * Drop a course
     *
     * @param  Request  $request
     * @param  Course  $course
     * @return Response
     */
    public function drop(Request $request, Course $course)
    {
        $request->user()->courses()->where('course_id', '=', $course->id)->detach();

        return redirect()->action('CourseController@index');
    }



}

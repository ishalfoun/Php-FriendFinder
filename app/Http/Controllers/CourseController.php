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

            //search for other courses (based on keywords found in the course number, title or teacher)
            $courses = Course::where('title', 'ILIKE', '%' . $searchKey . '%')->orWhere('class', 'ILIKE', '%' . $searchKey . '%')->orWhere('teacher', 'ILIKE', '%' . $searchKey . '%')->simplePaginate(20);
            $resultsToExclude=$this->filterSearch($request);

            return  view('courses.result', ['courses' => $courses, 'key'=>$searchKey, 'excludeList' => $resultsToExclude]);

        }else{
            //otherwise, show first page of results
            $this->validate($request, [
                'searchKey' => 'required|max:255',
            ]);

            $searchKey = strtolower($request->searchKey);

            //search for other courses (based on keywords found in the course number, title or teacher
            $courses = Course
                ::where('title', 'ILIKE', '%' . $searchKey . '%')->orWhere('class', 'ILIKE', '%' . $searchKey . '%')->orWhere('teacher', 'ILIKE', '%' . $searchKey . '%')->simplePaginate(20);
            $resultsToExclude=$this->filterSearch($request);

            return  view('courses.result', ['courses' => $courses, 'key'=>$searchKey, 'excludeList' => $resultsToExclude]);

        }


    }

    /**
     * Filters search results to not include classes the student isn't already registered in
     *
     * @param  Request $request
     * @param $searchKey
     * @return array
     */
    public function filterSearch($request)
    {

        $registeredCourses = $request->user()->courses()->get();

        $resultsToExclude = [];

        foreach ($registeredCourses as $registeredCourse) {
            $resultsToExclude[] = $registeredCourse->course_id;
        }

        return $resultsToExclude;

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

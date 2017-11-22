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
        echo 'hello';
        return view('courses.index', ['courses' => $courses,]);
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
        echo 'searching for: '.$searchkey;
        $found = DB::table('courses')->where('title', 'LIKE', "%$searchkey%")->first();
        if ($found) {
            echo 'found: ' . $found->title;
        }
        else
            echo 'not found';

    }



    //TODO CHANGE THIS!!
    /**
     * Create a new task.
     *
     * @param  Request  $request
     * @return Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|max:255',
        ]);

        $request->user()->tasks()->create([
            'name' => $request->name,
        ]);

    }

    /**
     * Destroy the given task.
     *
     * @param  Request  $request
     * @param  Task  $task
     * @return Response
     */
    public function destroy(Request $request, Task $task)
    {
        //
    }

    //TODO: CHANGE THIS!!

}

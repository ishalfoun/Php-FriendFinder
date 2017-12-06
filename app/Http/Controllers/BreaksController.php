<?php

namespace App\Http\Controllers;

use App\User;
use App\Course;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BreaksController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display form to enter day and time
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('breaks.index');
    }

    /**
     * Search for free breaks
     *
     * @param  Request  $request
     * @return Response
     */
    public function find(Request $request)
    {
        $this->validate($request, [
            'day' => 'required|max:10|regex:(^[{1}{2}{3}{4}{5}]$)',
            'start' => 'required|max:5|regex:(^\d\d:\d\d$)',
            'end' => 'required|max:5|regex:(^\d\d:\d\d$)',
        ]);
        $start = str_replace(':', '', $request->start);
        $end = str_replace(':', '', $request->end);
        $day = $request->day;

        if ($start > $end) {
            $errors = collect(["Start time must be before end time"]);
            return view('breaks.index', ['errors' => $errors]);
        }
        if ($start == $end) {
            $errors = collect(["Start time must be different from end time"]);
            return view('breaks.index', ['errors' => $errors]);
        }

        //get all the users friends
        $friends = $request->user()->friends()->where('status', '=', 'Confirmed')->get();


        $freeFriends = collect(); //new collection to be returned to the view

        //loop through each friend
        foreach ($friends as $friend) {

            //get a list of courses for that friend, on that day, sorted by starttime
            $courses = DB::table('users')
                ->select(DB::raw('title, section, starttime,endtime'))
                ->join('course_user', 'users.id', '=', 'course_user.user_id')
                ->join('courses', 'course_user.course_id', '=', 'courses.id')
                ->join('course_slot', 'courses.id', '=', 'course_slot.course_id')
                ->join('slots', 'slot_id', '=', 'slots.id')
                ->where('users.id', '=', $friend->id)
                ->where('day', '=', $day)
                ->orderBy('starttime')
                ->distinct()
                ->get();

            //
            //
            //DEBUGGING vvv
//            echo 'DEBUG<br>' . $friend->name . ' has ' . count($courses) . ' courses on that day';
//            foreach ($courses as $course)
//                echo '<br>__' . $course->title . ' ' . $course->starttime . '-' . $course->endtime;
            //DEBUGGING ^^^
            //
            //

            if (!$courses->first()) //that friend is not registered in any courses
            {
                $freeFriends->push($friend); // they are technically free
                continue;
            }
            else if ($courses->first()->starttime > $start)
            { //if start time of their first course is strictly greater than the start time of your break then they are free
                $freeFriends->push($friend); // they are free
                continue;
            }
            else if (count($courses)==1) //if they only have one course that day
            {
                if ($courses->first()->endtime < $end)
                {
                    $freeFriends->push($friend); // they are free
                    continue;
                }
            }
            else{
                for ($i = 0; $i < count($courses) - 1; $i++)
                {
                    if ($courses[$i]->endtime < $courses[$i + 1]->starttime //If the end time of course is strictly
                        // less that start time of friend’s next course
                        && $courses[$i]->endtime < $end // and strictly less than the end time of the break
                        && $courses[$i]->endtime >= $start)//and greater than or equal to the start time of a break,
                    {
                        $freeFriends->push($friend); // they are free
                        continue;
                    }
                }

            }

        }

        return  view('breaks.result', ['friends' => $freeFriends, 'day' =>  $request->day, 'start'=>$request->start, 'end' => $request->end]);
    }
}

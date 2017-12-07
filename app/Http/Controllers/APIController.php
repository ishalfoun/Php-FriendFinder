<?php

namespace App\Http\Controllers;

use App\User;
use App\Course;
use App\Friend;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class APIController extends Controller
{


    /**
     * Returns all friends of the given user
     * @param request the request object
     *
     */
    public function allFriends(Request $request)
    {
        //validates the credentials
        $credentials = $request->only('email', 'password');
        $valid = Auth::once($credentials);
        //if not valid returns error
        if (!$valid)
            return response()->json(['error' => 'invalid credentials'], 401);
        //returns all the friends of the given user
        else {
            $user = Auth::user();
            $friends = $user->friends()->where('status', '=', 'Confirmed')->get();
            return response()->json($friends, 200);
        }
    }

    /**
     * Get friends who are not in class at any point within the supplied period
     * Fetch all friends of the user (with authentication credentials email and password), who are not
     * in a class at some point during the supplied period. The period is specified by day, start time and end time.
     * @param Request $request
     * @return mixed
     */
    public function breakFriends(Request $request)
    {
        //validates user
        $credentials = $request->only('email', 'password');
        $valid = Auth::once($credentials);
        //if not valid return error
        if (!$valid)
            return response()->json(['error' => 'invalid credentials'], 401);

        else {
            //extract data from request object
            $day = $request->input('day');
            $start = $request->input('start');
            $end = $request->input('end');
            //validate data, if wrong send error
            if ($day == null || $start == null || $start < 1000 || $start > 1730 || $start >= $end || $end == null || $end < 1000 || $end > 1730) {
                return response()->json(['error' => 'bad or missing parameter'], 400);
            } //find friends who are on break between the given times
            else {
                $user = Auth::user();
                $friends = $this->friendsOnBreak($user, $day, $start, $end); //CHANGE TO GET FRIENDS
                return response()->json($friends, 200);
            }
        }
    }

    /**
     * Finds and returns the friends in the given course
     * @param Request the request object
     * @return code401 invalid creds
     * @return code400 bad or missing parameters
     * @return code200 friends in given course, null if no friends in course
     */
    public function courseFriends(Request $request)
    {
        //Validates if the email and password match an entry
        $credentials = $request->only('email', 'password');
        $valid = Auth::once($credentials);
        //if not valid returns error
        if (!$valid)
            return response()->json(['error' => 'invalid credentials'], 401);
        else {
            //extracts coursename and section from request
            $coursename = $request->input('coursename');
            $section = $request->input('section');
            //if null returns error code
            if ($coursename == null || $section == null) {
                return response()->json(['error' => 'bad or missing parameter'], 400);
            } else {
                //finds and returns friends in given course
                $user = Auth::user();
                $friends = $this->friendsInCourse($user, $coursename, $section);
                return response()->json($friends, 200);
            }
        }
    }

    /**
     * Finds which course a friend is at a given time, null if in no classess
     * @param request the rquest object
     * @return code401 invalid crendentials
     * @return code400 bad or missing parameters or user not a friend
     * @return code200 the course the friend is in, null if no courses.
     */
    public function whereIsFriend(Request $request)
    {
        //validate user
        $credentials = $request->only('email', 'password');
        $valid = Auth::once($credentials);
        //if not valid return error
        if (!$valid)
            return response()->json(['error' => 'invalid credentials'], 401);
        //extract email, day time from request
        $friendemail = $request->input('friendemail');
        $day = $request->input('day');
        $time = $request->input('time');
        //get user object from authentication
        $user = Auth::user();
        //validates data, if wrong return error
        if ($friendemail == null || $day == null || $day < 1 || $day > 5 || $time == null) {
            return response()->json(['error' => 'bad or missing parameter'], 400);
        } //checks if user is a friend if not returns error
        else if (!$this->isFriend($user, $friendemail)) {
            return response()->json(['error' => 'not friend'], 400);
        } //finds the course the user is in at the given time
        else {
            $course = $this->getFriendCurrentCourse($friendemail, $day, $time);
            return response()->json($course, 200);
        }

    }
//================================HELPER FUNCTIONS============================================

    /**
     * @param user the user
     * @param day the day number
     * @param start the start time to find when the friends are on break
     * @param end the end time to find when the friends are on break
     */
    private function friendsOnBreak($user, $day, $start, $end)
    {
        $friends = $user->friends()->where('status', '=', 'Confirmed')->get();
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
            if (!$courses->first()) //that friend is not registered in any courses
            {
                $freeFriends->push($friend); // they are technically free
                continue;
            } else //if start time of their first course is strictly greater than the start time of your break then they are free
                if ($courses->first()->starttime > $start) {
                    $freeFriends->push($friend); // they are free
                    continue;
                } else {
                    for ($i = 0; $i < count($courses) - 1; $i++) {
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
        return $freeFriends;
    }

    /**
     *Helper function, finds and returns list of friends in the given course
     * @param user the current user
     * @param course the course name
     * @param section the section number
     * @return enrolledFriends returns the friends enrolled
     */
    private function friendsInCourse($user, $course, $section)
    {
        //get friend list
        $friends = $user->friends()->where('status', '=', 'Confirmed')->get();
        //collection to push friends in class
        $enrolledFriends = collect();
        //loop through each friend
        foreach ($friends as $friend) {
            //if the course is found, add it to the list
            $courses = $friend->courses()->where('title', '=', $course)->where('section', '=', $section)->first();
            //$enrolledFriends->push($courses);
            if ($courses != null) {
                $enrolledFriends->push($friend);
            }
        }
        //return the list of enrolled friends
        return $enrolledFriends;
    }

    /**
     * Determines if the user is friends or not with the entered email
     * @param user the current user
     * @param friendemail the email of the friend
     * @return isFriend returns true or false if friend or not
     */
    private function isFriend($user, $friendemail)
    {
        //tries to find friend with that email
        $friend = $user->friends()->where('email', '=', $friendemail)->first();
        //returns false if null true if it found the friend
        if ($friend != null)
            return true;
        return false;
    }

    /**
     * Finds if a friend is currently in a course, returns null if is free
     * @param friendemail the email of the friend
     * @param day the day number
     * @param time the time of the day to find the friend
     */
    private function getFriendCurrentCourse($friendemail, $day, $time)
    {
        //get friend object and the friend's courses
        $friend = User::where('email', '=', $friendemail)->first();

        $courses = $friend->courses()->get();
        //loop through each course
        foreach ($courses as $course) {
            //get the slot where the time falls between the time, if it finds it , it will return the current course
            $slot = $course->slots()->where('day', '=', $day)->where('starttime', '<=', $time)->where('endtime', '>=', $time)->first();
            if ($slot != null) {
                return $course;
            }
        }
        //if no courses fall in that time, it will return null
        return null;
    }
}
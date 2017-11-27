<?php

namespace App\Http\Controllers;

use App\Friend;
use App\User;
use Illuminate\Http\Request;

class FriendController extends Controller
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
     * Display a list of all of the user's friends.
     *
     * @param  Request  $request
     * @return Response
     */
    public function index(Request $request)
    {
        $friends = $request->user()->friends()->get();

        return view('friends.index', ['friends' => $friends,]);
    }


    /**
     * Search Friends
     *
     * @param  Request  $request
     * @return Response
     */
    public function search(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|max:255',
        ]);

        $searchkey = strtolower($request->name);

        $friends = User
            ::where('name', 'ILIKE', '%' . $searchkey . '%')->simplePaginate(20);


        return  view('friends.result', ['friends' => $friends, 'key'=>$searchkey]);

    }

    //TODO: CHANGE THIS!!
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

        return redirect('/tasks');

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

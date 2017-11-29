<?php

namespace App\Http\Controllers;

use App\Friend;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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
     * @param  Request $request
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
     * @param  Request $request
     * @return Response
     */
    public function search(Request $request)
    {

        //is this a request for the next page? (pagination)
        if ($request->has('page') && $request->has('searchKey')) {

            $searchKey = strtolower($request->searchKey);

            $friends = User::where('name', 'ILIKE', '%' . $searchKey . '%')->simplePaginate(20);

            return view('friends.result', ['friends' => $friends, 'key' => $searchKey]);

        } else {
            $this->validate($request, [
                'name' => 'required|max:255',
            ]);

            $searchkey = strtolower($request->name);

            $friends = User
                ::where('name', 'ILIKE', '%' . $searchkey . '%')->simplePaginate(20);


            return view('friends.result', ['friends' => $friends, 'key' => $searchkey]);

        }
    }

    /**
     * Send a friend request.
     *
     * @param  Request  $request
     * @param  User $user
     * @return Response
     */
    public function register(Request $request, User $user)
    {
        $request->user()->friends()->associate($user->id);

        return redirect()->action('FriendController@index');
    }

    /**
     * Unfriend Someone
     *
     * @param  Request  $request
     * @param  User $user
     * @return Response
     */
    public function drop(Request $request, User $user)
    {
        $request->user()->friends()->where('friend2_id', '=', $user->id)->detach();

        return redirect()->action('FriendController@index');
    }
}

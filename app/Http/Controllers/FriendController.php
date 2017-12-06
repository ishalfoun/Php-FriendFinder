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
        $friends = FriendController::friendListHelper($request)[0];
        $friendRequestsReceived = FriendController::friendListHelper($request)[1];
        $friendRequestsSent = $request->user()->friends()->where('status', 'Sent')->get();

        return view('friends.index', ['friends' => $friends, 'friendRequestsSent' => $friendRequestsSent, 'friendRequestsReceived' => $friendRequestsReceived,]);
    }

    public static function friendListHelper(Request $request)
    {
        $friends = $request->user()->friends()->where('status', 'Confirmed')->get();
        $friendRequestsReceived = $request->user()->friends()->where('status', 'Received')->get();
        return [$friends, $friendRequestsReceived];
    }


    /**
     * Filters search results to not include friends that are pending or confirmed
     * or the user itself.
     *
     * @param  Request $request
     * @param $searchKey
     * @return array
     */
    public function filterSearch($request)
    {

        $friendRequestsSent = $request->user()->friends()->where('status', 'Sent')->get();
        $friendRequestsReceived = $request->user()->friends()->where('status', 'Received')->get();
        $friendsApproved = $request->user()->friends()->where('status', 'Confirmed')->get();

        $resultsToExclude = [];

        $resultsToExclude[] = $request->user()->id;

        foreach ($friendsApproved as $friendApproved) {
            $resultsToExclude[] = $friendApproved->id;
        }
        foreach ($friendRequestsSent as $friendsSent) {
            $resultsToExclude[] = $friendsSent->id;
        }
        foreach ($friendRequestsReceived as $friendsReceived) {
            $resultsToExclude[] = $friendsReceived->id;
        }


        return $resultsToExclude;

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
            $resultsToExclude=$this->filterSearch($request);

            return view('friends.result', ['friends' => $friends, 'key' => $searchKey, 'excludeList' => $resultsToExclude]);

        } else {
            $this->validate($request, [
                'searchKey' => 'required|max:255',
            ]);

            $searchKey = strtolower($request->searchKey);
            $friends = User::where('name', 'ILIKE', '%' . $searchKey . '%')->simplePaginate(20);
            $resultsToExclude=$this->filterSearch($request);

            return view('friends.result', ['friends' => $friends, 'key' => $searchKey, 'excludeList' => $resultsToExclude]);
        }
    }

    /**
     * Send a friend request.
     *
     * @param  Request $request
     * @return Response
     */
    public function requestFriend(Request $request, User $friend)
    {

        $requester = new Friend;
        $receiver = new Friend;

        $friend1Name = User::where('id', '=', $request->user()->id)->get()[0]->name;
        $friend2Name = User::where('id', '=', $friend->id)->get()[0]->name;


        $requester->friend1_id = $request->user()->id;
        $requester->friend1_name = $friend1Name;
        $requester->friend2_id = $friend->id;
        $requester->friend2_name = $friend2Name;
        $requester->status = "Sent";

        $receiver->friend1_id = $friend->id;
        $receiver->friend1_name = $friend2Name;
        $receiver->friend2_id = $request->user()->id;
        $receiver->friend2_name = $friend1Name;
        $receiver->status = "Received";

        $requester->save();
        $receiver->save();

        return redirect()->action('FriendController@index');
    }

    /**
     * Accept a friend request.
     *
     * @param  Request $request
     * @return Response
     */
    public function acceptFriend(Request $request, User $friend)
    {
        //update relationships to confirmed
        Friend::where('friend1_id', '=', $request->user()->id)->where('friend2_id', '=', $friend->id)->update(['status' => "Confirmed"]);
        Friend::where('friend1_id', '=', $friend->id)->where('friend2_id', '=', $request->user()->id)->update(['status' => "Confirmed"]);

        return redirect()->action('FriendController@index');
    }

    /**
     * Unfriend or decline request Someone
     *
     * @param  Request $request
     * @param  User $user
     * @return Response
     */
    public function declineFriend(Request $request, User $friend)
    {
        Friend::where('friend1_id', '=', $request->user()->id)->where('friend2_id', '=', $friend->id)->delete();
        Friend::where('friend1_id', '=', $friend->id)->where('friend2_id', '=', $request->user()->id)->delete();

        return redirect()->action('FriendController@index');
    }

}

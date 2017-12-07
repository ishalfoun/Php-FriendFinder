<!-- resources/views/friends/index.blade.php -->

@extends('layouts.app')

@section('content')

    <!-- Bootstrap Boilerplate... -->

    <div class="panel-body">
        <!-- Display Validation Errors -->
    @include('common.errors')

    <!-- New friend Form -->
        <form action="{{ url('friend/') }}" method="POST" class="form-horizontal">
        {{ csrf_field() }}

        <!-- friend Name -->
            <div class="form-group">
                <label for="friend-name" class="col-sm-3 control-label">Search for a classmate</label>

                <div class="col-sm-6">
                    <input type="text" name="searchKey" id="friend-name" class="form-control">
                </div>
            </div>

            <!-- Search friend Button -->
            <div class="form-group">
                <div class="col-sm-offset-3 col-sm-6">
                    <button type="submit" class="btn btn-default">
                        <i class="fa fa-plus"></i> Search
                    </button>
                </div>
            </div>
        </form>

        <!-- Current Friends -->
        @if (count($friends) > 0)
            <div class="panel panel-default">
                <div class="panel-heading">
                    Current Friends
                </div>

                <div class="panel-body">
                    <table class="table table-striped friend-table">

                        <!-- Table Headings -->
                        <thead>
                        <th>Friends</th>
                        <th>&nbsp;</th>
                        </thead>

                        <!-- Table Body -->
                        <tbody>
                        @foreach ($friends as $friend)
                            <tr>
                                <!-- Friend Name -->
                                <td class="table-text">
                                    <div>{{ $friend->name }}</div>
                                </td>

                                <td>
                                    <!-- Delete Button -->
                                    <form action="{{ url('friend/unFriend/'.$friend->id) }}" method="POST">
                                        {{ csrf_field() }}
                                        {{ method_field('DELETE') }}

                                        <button type="submit" id="delete-friend-{{ $friend->id }}"
                                                class="btn btn-danger">
                                            <i class="fa fa-btn fa-trash"></i>Unfriend
                                        </button>
                                    </form>

                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        @else
            <div class="panel panel-default">
                <div class="panel-heading">
                    You have no friends assigned.
                </div>
            </div>
        @endif
    <!-- Friend Requests (Outbound) -->
        @if (count($friendRequestsSent) > 0)
            <div class="panel panel-default">
                <div class="panel-heading">
                    Friend Requests Pending
                </div>

                <div class="panel-body">
                    <table class="table table-striped friend-table">

                        <!-- Table Body -->
                        <tbody>
                        @foreach ($friendRequestsSent as $friend)
                            <tr>
                                <!-- Friend Name -->
                                <td class="table-text">
                                    <div>{{ $friend->name }}</div>
                                </td>
                                <td>
                                    <!-- Delete Button -->
                                    <form action="{{ url('friend/unFriend/'.$friend->id) }}" method="POST">
                                        {{ csrf_field() }}
                                        {{ method_field('DELETE') }}

                                        <button type="submit" id="delete-friend-{{ $friend->id }}"
                                                class="btn btn-danger">
                                            <i class="fa fa-btn fa-trash"></i>Cancel Friend Request
                                        </button>
                                    </form>

                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        @else
            <div class="panel panel-default">
                <div class="panel-heading">
                    No new friend requests sent.
                </div>
            </div>
        @endif

    <!-- Friend Requests (Inbound) -->
        @if (count($friendRequestsReceived) > 0)
            <div class="panel panel-default">
                <div class="panel-heading">
                    New Friend Requests
                </div>

                <div class="panel-body">
                    <table class="table table-striped friend-table">

                        <!-- Table Body -->
                        <tbody>
                        @foreach ($friendRequestsReceived as $friend)
                            <tr>
                                <!-- Friend Name -->
                                <td class="table-text">
                                    <div>{{ $friend->name }}</div>
                                </td>
                                <td>
                                    <!-- Accept Button -->
                                    <form action="{{ url('friend/addFriend/'.$friend->id) }}" method="POST">
                                        {{ csrf_field() }}
                                        {{ method_field('PUT') }}

                                        <button type="submit" id="add-friend-{{ $friend->id }}" class="btn btn-danger">
                                            <i class="fa fa-btn fa-trash"></i>Add Friend
                                        </button>
                                    </form>

                                </td>
                                <td>
                                    <!-- Decline Button -->
                                    <form action="{{ url('friend/unFriend/'.$friend->id) }}" method="POST">
                                        {{ csrf_field() }}
                                        {{ method_field('DELETE') }}

                                        <button type="submit" id="delete-friend-{{ $friend->id }}"
                                                class="btn btn-danger">
                                            <i class="fa fa-btn fa-trash"></i>Decline
                                        </button>
                                    </form>

                                </td>

                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        @else
            <div class="panel panel-default">
                <div class="panel-heading">
                    No new friend requests received.
                </div>
            </div>
        @endif
    </div>

@endsection

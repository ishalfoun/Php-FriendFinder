
@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">Dashboard</div>

                    <div class="panel-body">
                        @if (session('status'))
                            <div class="alert alert-success">
                                {{ session('status') }}
                            </div>
                        @endif

                        <h2> Welcome {{Auth::user()->name}} !</h2>
                        <ul>
                            <li><a href='/courses'>Course Manager</a></li>
                            <li><a href='/friends'>Friends Manager</a></li>
                            <li><a href='/breaks'>Find Friends with Matching Breaks</a></li>
                        </ul>
                    </div>

                    <!-- Current Courses -->
                    @if (count($courses) > 0)
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                Current Courses
                            </div>

                            <div class="panel-body">
                                <table class="table table-striped course-table">

                                    <!-- Table Headings -->
                                    <thead>
                                    <th>Class</th>
                                    <th>Title</th>
                                    <th>Section</th>
                                    <th>Teacher</th>
                                    </thead>

                                    <!-- Table Body -->
                                    <tbody>
                                    @foreach ($courses as $course)
                                        <tr>
                                            <!-- Course Class -->
                                            <td class="table-text">
                                                <div>{{ $course->class }}</div>
                                            </td>
                                            <!-- Course Title -->
                                            <td class="table-text">
                                                <div>{{ $course->title }}</div>

                                            </td><!-- Course Section -->
                                            <td class="table-text">
                                                <div>{{ $course->section }}</div>

                                            </td><!-- Course Teacher -->
                                            <td class="table-text">
                                                <div>{{ $course->teacher }}</div>
                                            </td>

                                            <td class="table-text">
                                                <form action="{{ url('course/drop/'.$course->id) }}" method="POST">
                                                    {{ csrf_field() }}
                                                    {{ method_field('DELETE') }}

                                                    <button type="submit" id="delete-course-{{ $course->id }}" class="btn btn-danger">
                                                        <i class="fa fa-btn fa-trash"></i>Drop
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
                                You are not enrolled in any classes.
                            </div>
                        </div>
                    @endif


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

                                                    <button type="submit" id="delete-friend-{{ $friend->id }}" class="btn btn-danger">
                                                        <i class="fa fa-btn fa-trash"></i>Unfriend
                                                    </button>
                                                </form>

                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                                {{ $friends->links() }}
                            </div>
                        </div>
                    @else
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                You have no friends assigned.
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

                                                    <button type="submit" id="delete-friend-{{ $friend->id }}" class="btn btn-danger">
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
            </div>
        </div>
    </div>
@endsection

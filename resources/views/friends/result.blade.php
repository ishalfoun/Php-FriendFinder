<!-- resources/views/courses/index.blade.php -->

@extends('layouts.app')

@section('content')

    <!-- Bootstrap Boilerplate... -->

    <div class="panel-body">
        <!-- Display Validation Errors -->
    @include('common.errors')


    <!-- Search Friend Form -->
        <form action="{{ url('friend/') }}" method="POST" class="form-horizontal">
        {{ csrf_field() }}

        <!-- Friend Name -->
            <div class="form-group">
                <label for="course-name" class="col-sm-3 control-label">Search for a classmate</label>

                <div class="col-sm-6">
                    <input type="text" name="searchKey" id="course-name" class="form-control">
                </div>
            </div>

            <!-- Add Friend Button -->
            <div class="form-group">
                <div class="col-sm-offset-3 col-sm-7">
                    <button type="submit" class="btn btn-default">
                        <i class="fa fa-plus"></i> Search
                    </button>
                </div>
            </div>
        </form>
    </div>


    <!-- Friend Search Results -->
    @if (count($friends) > 0)
        <div class="panel panel-default">
            <div class="panel-heading">
                Search Results for '{{$key}}'
            </div>
            <div class="panel-body">
                <table class="table table-striped course-table">

                    <!-- Table Headings -->
                    <thead>
                    <th>Name</th>
                    <th>Program</th>
                    </thead>

                    <!-- Table Body -->
                    <tbody>
                    @foreach ($friends as $friend)
                        <!-- Do not show names in the exclude list-->

                        @if(!in_array($friend->id,$excludeList))
                        <tr>
                            <!-- Friend Name -->
                            <td class="table-text">
                                <div>{{ $friend->name }}</div>
                            </td>

                            <!-- Friend Program -->
                            <td class="table-text">
                                <div>{{ $friend->program }}</div>
                            </td>

                            <!-- Send Friend Request button -->
                            <td class="table-text">
                                <form action="{{ url('friend/requestFriend/'.$friend->id) }}" method="POST">
                                    {{ csrf_field() }}
                                    {{ method_field('PUT') }}

                                    <button type="submit" id="requestFriend-friend-{{ $friend->id }}" class="btn btn-danger">
                                        <i class="fa fa-btn fa-trash"></i>Send Friend Request
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @else
                            <tr>
                                <!-- Friend Name -->
                                <td class="table-text">
                                    <div>{{ $friend->name }}</div>
                                </td>

                                <!-- Friend Program -->
                                <td class="table-text">
                                    <div>{{ $friend->program }}</div>
                                </td>

                                <td class="table-text">
                                Already your friend or there is a pending request.
                                </td>
                            </tr>
                        @endif
                    @endforeach
                    </tbody>
                </table>

                {{ $friends->appends(['searchKey' => $key ])->links() }}
            </div>
        </div>
    @else
        <div class="panel panel-default">
            <div class="panel-heading">
               No results found for '{{$key}}'
            </div>
        </div>
    @endif
    @if(!isset($atLeastOneResult))

        <div class="panel panel-default">
            <div class="panel-heading">
            </div>
        </div>
    @endif
@endsection

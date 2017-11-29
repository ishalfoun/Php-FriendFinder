<!-- resources/views/courses/index.blade.php -->

@extends('layouts.app')

@section('content')

    <!-- Bootstrap Boilerplate... -->

    <div class="panel-body">
        <!-- Display Validation Errors -->
    @include('common.errors')


    <!-- Search Friend Form -->
        <form action="{{ url('course') }}" method="POST" class="form-horizontal">
        {{ csrf_field() }}

        <!-- Friend Name -->
            <div class="form-group">
                <label for="course-name" class="col-sm-3 control-label">Search for a classmate</label>

                <div class="col-sm-6">
                    <input type="text" name="name" id="course-name" class="form-control">
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
                    </thead>

                    <!-- Table Body -->
                    <tbody>
                    @foreach ($friends as $friend)
                        <tr>
                            <!-- Friend Name -->
                            <td class="table-text">
                                <div>{{ $friend->name }}</div>
                            </td>

                            <td class="table-text">
                                <form action="{{ url('friend/addFriend/'.$friend->id) }}" method="POST">
                                    {{ csrf_field() }}
                                    {{ method_field('PUT') }}

                                    <button type="submit" id="addFriend-friend-{{ $friend->id }}" class="btn btn-danger">
                                        <i class="fa fa-btn fa-trash"></i>Send Friend Request
                                    </button>
                                </form>
                            </td>
                        </tr>
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

@endsection

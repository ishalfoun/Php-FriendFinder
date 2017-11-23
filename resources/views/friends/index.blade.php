<!-- resources/views/friends/index.blade.php -->

@extends('layouts.app')

@section('content')

    <!-- Bootstrap Boilerplate... -->

    <div class="panel-body">
        <!-- Display Validation Errors -->
    @include('common.errors')

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
                        <th>Friend</th>
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
                                    <form action="{{ url('friend/'.$friend->id) }}" method="POST">
                                        {{ csrf_field() }}
                                        {{ method_field('DELETE') }}

                                        <button type="submit" id="delete-friend-{{ $friend->id }}" class="btn btn-danger">
                                            <i class="fa fa-btn fa-trash"></i>Delete
                                        </button>
                                    </form>

                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
    @endif


    <!-- New friend Form -->
        <form action="{{ url('friend') }}" method="POST" class="form-horizontal">
        {{ csrf_field() }}

        <!-- friend Name -->
            <div class="form-group">
                <label for="friend-name" class="col-sm-3 control-label">Friend</label>

                <div class="col-sm-6">
                    <input type="text" name="name" id="friend-name" class="form-control">
                </div>
            </div>

            <!-- Add friend Button -->
            <div class="form-group">
                <div class="col-sm-offset-3 col-sm-6">
                    <button type="submit" class="btn btn-default">
                        <i class="fa fa-plus"></i> Add friend
                    </button>
                </div>
            </div>
        </form>
    </div>

@endsection

<!-- resources/views/courses/index.blade.php -->

@extends('layouts.app')

@section('content')

    <!-- Bootstrap Boilerplate... -->

    <div class="panel-body">
        <!-- Display Validation Errors -->
    @include('common.errors')


    <!-- Search Course Form -->
        <form action="{{ url('course/') }}" method="POST" class="form-horizontal">
        {{ csrf_field() }}

        <!-- Course Name -->
            <div class="form-group">
                <label for="course-name" class="col-sm-3 control-label">Search for course</label>

                <div class="col-sm-6">
                    <input type="text" name="searchKey" id="course-name" class="form-control">
                </div>
            </div>

            <!-- Add Course Button -->
            <div class="form-group">
                <div class="col-sm-offset-3 col-sm-7">
                    <button type="submit" class="btn btn-default">
                        <i class="fa fa-plus"></i> Search
                    </button>
                </div>
            </div>
        </form>
    </div>


    <!-- Course Search Results -->
    @if (count($courses) > 0)
        <div class="panel panel-default">
            <div class="panel-heading">
                Search Results for '{{$key}}'
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
                            <form action="{{ url('course/register/'.$course->id) }}" method="POST">
                                {{ csrf_field() }}
                                {{ method_field('PUT') }}

                                <button type="submit" id="register-course-{{ $course->id }}" class="btn btn-danger">
                                    <i class="fa fa-btn fa-trash"></i>Register
                                </button>
                            </form>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
                {{ $courses->appends(['searchKey' => $key ])->links() }}
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

<!-- resources/views/courses/index.blade.php -->

@extends('layouts.app')

@section('content')

    <!-- Bootstrap Boilerplate... -->

    <div class="panel-body">
        <!-- Display Validation Errors -->
    @include('common.errors')


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
                        <th>Course</th>
                        <th>&nbsp;</th>
                        </thead>

                        <!-- Table Body -->
                        <tbody>
                        @foreach ($courses as $course)
                            <tr>
                                <!-- Course Name -->
                                <td class="table-text">
                                    <div>{{ $course->name }}</div>
                                </td>

                                <td>
                                    <!-- TODO: Delete Button -->
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

    <!-- Search Course Form -->
        <form action="{{ url('course') }}" method="POST" class="form-horizontal">
        {{ csrf_field() }}

        <!-- Course Name -->
            <div class="form-group">
                <label for="course-name" class="col-sm-3 control-label">Search for course</label>

                <div class="col-sm-6">
                    <input type="text" name="name" id="course-name" class="form-control">
                </div>
            </div>

            <!-- Add Course Button -->
            <div class="form-group">
                <div class="col-sm-offset-3 col-sm-6">
                    <button type="submit" class="btn btn-default">
                        <i class="fa fa-plus"></i> Search
                    </button>
                </div>
            </div>
        </form>
    </div>


@endsection

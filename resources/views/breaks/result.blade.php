<!-- resources/views/courses/index.blade.php -->

@extends('layouts.app')

@section('content')

    <!-- Bootstrap Boilerplate... -->

    <div class="panel-body">
        <!-- Display Validation Errors -->
    @include('common.errors')


    <!-- insert Search Form here-->


    </div>




    <!-- Course Search Results -->
    @if (count($friends) > 0)
        <div class="panel panel-default">
            <div class="panel-heading">
                Searching for Friends with free break on :<h3>
                @if ($day==1)
                    Monday
                @elseif ($day==2)
                    Tuesday
                @elseif ($day==3)
                    Wednesday
                @elseif ($day==4)
                    Thursday
                @elseif ($day==5)
                    Friday
                @endif
                from {{$start}}  to {{$end}}</h3>
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
                    @foreach ($friends as $course)
                        <tr>
                            <!-- Course Class -->
                            <td class="table-text">
                                <div>{{ $course->name }}</div>
                            </td>
                            <!-- Course Title -->
                            <td class="table-text">
                                <div>{{ $course->program }}</div>


                        </tr>
                    @endforeach
                    </tbody>
                </table>

            </div>
        </div>
    @else
        <div class="panel panel-default">
            <div class="panel-heading">
                No Friends have a free break on <h3>
                @if ($day==1)
                    Monday
                @elseif ($day==2)
                    Tuesday
                @elseif ($day==3)
                    Wednesday
                @elseif ($day==4)
                    Thursday
                @elseif ($day==5)
                    Friday
                @endif
                    from {{$start}}  to {{$end}} </h3>
            </div>
        </div>
    @endif




@endsection

<!-- resources/views/breaks/index.blade.php -->

@extends('layouts.app')

@section('content')

    <!-- Bootstrap Boilerplate... -->

    <div class="panel-body">
        <!-- Display Validation Errors -->
    @include('common.errors')

    <!-- New Break Form -->
        <form action="{{ url('breaks') }}" method="POST" class="form-horizontal">
        {{ csrf_field() }}

            <div class="panel-heading">Find Friends on Break between 10:00-17:00</div>
        <!-- Break Name -->
            <div class="form-group">
                <label for="break-day" class="col-sm-3 control-label">Day</label>

                <div class="col-sm-6">
                    <select class="form-control" id="break-day"  name="day">
                        <option value={{1}}>Monday</option>
                        <option value={{2}}>Tuesday</option>
                        <option value={{3}}>Wednesday</option>
                        <option value={{4}}>Thursday</option>
                        <option value={{5}}>Friday</option>
                    </select>
                </div>
            </div>
            <div class="form-group">

                <label for="break-start" class="col-sm-3 control-label">Start Time</label>

                <div class="col-sm-6">
                    <select class="form-control" id="break-start" name="start">
                        @for($i=10; $i<18; $i++)
                            @for($j=0; $j<4; $j+=3)
                                @if ($i==17 && $j==3)
                                    @break
                                @endif
                                <option value={{$i}}:{{$j}}0>{{$i}}:{{$j}}0</option>
                            @endfor
                        @endfor
                    </select>
                </div>
            </div>
            <div class="form-group">

                <label for="break-end" class="col-sm-3 control-label">End Time</label>

                <div class="col-sm-6">
                    <select class="form-control" id="break-end" name="end">
                        @for($i=10; $i<18; $i++)
                            @for($j=0; $j<4; $j+=3)
                                @if ($i==17 && $j==3)
                                    @break
                                @endif
                                <option value={{$i}}:{{$j}}0>{{$i}}:{{$j}}0</option>
                            @endfor
                        @endfor
                    </select>
                </div>
            </div>

            <!-- Add Break Button -->
            <div class="form-group">
                <div class="col-sm-offset-3 col-sm-6">
                    <button type="submit" class="btn btn-default">
                        <i class="fa fa-plus"></i> Find
                    </button>
                </div>
            </div>
        </form>
    </div>

    <!-- TODO: Current Breaks -->
@endsection

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

            <div class="panel-heading">Find Friends on Break</div>
        <!-- Break Name -->
            <div class="form-group">
                <label for="break-day" class="col-sm-3 control-label">Day</label>

                <div class="col-sm-6">
                    <input type="text" name="day" id="break-day" class="form-control" placeholder="1=Monday 2=Tuesday...">
                </div>
            </div>
            <div class="form-group">

                <label for="break-start" class="col-sm-3 control-label">Start Time</label>

                <div class="col-sm-6">
                    <input type="text" name="start" id="break-start" class="form-control" placeholder="10:15">
                </div>
            </div>
            <div class="form-group">

                <label for="break-end" class="col-sm-3 control-label">End Time</label>

                <div class="col-sm-6">
                    <input type="text" name="end" id="break-end" class="form-control" placeholder="14:15">
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

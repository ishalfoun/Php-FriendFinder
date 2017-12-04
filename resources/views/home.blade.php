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
                            <li><a href='/breaks'>Fiend Friends with Matching Breaks</a></li>
                        </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

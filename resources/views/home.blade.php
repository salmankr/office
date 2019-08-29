@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Dashboard</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    @if(isset($message))
                    <div class="alert alert-danger" role="alert">
                        {{$message}}
                    </div>
                    <a class="btn btn-primary" href="{{route('verification.notice')}}" role="button">Go to Verification page</a>
                    @else
                    You are logged in!
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    @if(Auth::user()->provider)
                        {{ 'You are logged in using ' . Auth::user()->provider . ' account!'}}
                    @else
                        {{ 'You are logged in using AuthhApp account!' }}
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

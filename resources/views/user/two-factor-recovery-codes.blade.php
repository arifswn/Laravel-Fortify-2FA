@extends('layouts.app')

@section('content')
    <div class="col-md-6">
        <div class="card border-0 shadow rounded">
            <div class="card-body">

                <div class="d-flex justify-content-between align-items-center">
                    <h4 class="font-weight-bold mb-0">Two-Factor Recovery Codes</h4>
                    <a href="{{ url('/home') }}" class="btn btn-outline-secondary btn-sm">
                        <i class="fas fa-arrow-left"></i> Back
                    </a>
                </div>

                @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                @endif

                <hr>
                <ul>
                    @foreach ($recoveryCodes as $code)
                        <li>{{ $code }}</li>
                    @endforeach
                </ul>

                <a href="{{ url('user/two-factor-authentication') }}" class="btn btn-primary mt-3">Back</a>
            </div>
        </div>
    </div>
@endsection

@extends('layouts.app')

@section('content')
    <div class="col-md-6">
        <div class="card border-0 shadow rounded">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <h4 class="font-weight-bold mb-0">Two-Factor Authentication</h4>
                    <a href="{{ url('/') }}" class="btn btn-outline-secondary btn-sm">
                        <i class="fas fa-arrow-left"></i> Back to Login
                    </a>
                </div>
                @if (session('status'))
                    <div class="alert alert-success my-2" role="alert">
                        {{ session('status') }}
                    </div>
                @endif
                <hr>
                <form method="POST" action="{{ route('two-factor.login') }}">
                    @csrf
                    <div class="form-group">
                        <label for="code">Enter your two-factor authentication code</label>
                        <input type="text" name="code" id="code" class="form-control" required autofocus>
                    </div>
                    @if ($errors->any())
                        <div class="alert alert-danger" role="alert">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <button type="submit" class="btn btn-primary"><i class="fas fa-sign-in-alt"></i> Verify Two-Factor Code</button>
                </form>
                <hr>
                <div class="text-center">
                    <p class="mb-0">Forgot your two-factor authentication code?</p>
                    <a href="{{ route('two-factor.recovery-codes.forgot') }}" class="btn btn-outline-warning btn-sm">
                        <i class="fas fa-exclamation-triangle"></i> Use Recovery Code
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection

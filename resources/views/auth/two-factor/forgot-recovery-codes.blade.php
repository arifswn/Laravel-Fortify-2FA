@extends('layouts.app')

@section('content')
    <div class="col-md-6">
        <div class="card border-0 shadow rounded">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <h4 class="font-weight-bold mb-0">Recovery Code</h4>
                    {{-- back to back menu --}}
                    <a href="{{ route('two-factor.login') }}" class="btn btn-outline-secondary btn-sm">
                        <i class="fas fa-arrow-left"></i> Back to Two-Factor Authentication
                    </a>
                </div>
                @if (session('status'))
                    <div class="alert alert-success my-2" role="alert">
                        {{ session('status') }}
                    </div>
                @endif
                <hr>
                <form method="POST" action="{{ route('two-factor.recovery-codes.process') }}">
                    @csrf
                    <div class="form-group">
                        <label for="recovery_code">Enter your recovery code</label>
                        <input type="text" name="recovery_code" id="recovery_code" class="form-control" required
                            autofocus>
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

                    <button type="submit" class="btn btn-primary"><i class="fas fa-sign-in-alt"></i> Verify Recovery
                        Code</button>
                </form>
                <hr>
                <div class="text-center">
                    <p class="mb-0">Are you having trouble with your recovery code?</p>
                    <div class="alert alert-danger d-inline-block mt-2" role="alert">
                        <i class="fas fa-exclamation-triangle"></i>
                        &nbsp; &nbsp;
                        <strong>Notice:</strong> Please contact support. You may need to reset your two-factor
                        authentication.
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection

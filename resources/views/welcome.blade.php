@extends('layouts.app')

@section('content')
    <div class="d-flex flex-column min-vh-50 bg-light text-center rounded">
        @if (Route::has('login'))
            <div class="position-fixed top-0 end-0 p-3 text-end">
                @auth
                    <a href="{{ url('/home') }}" class="btn btn-outline-secondary"><i class="fas fa-home"></i> Home</a>
                @else
                    <a href="{{ route('login') }}" class="btn btn-outline-secondary"><i class="fas fa-sign-in-alt"></i>
                        Login</a>

                    @if (Route::has('register'))
                        <a href="{{ route('register') }}" class="btn btn-outline-secondary ms-2"><i class="fas fa-user-plus"></i>
                            Register</a>
                    @endif
                @endauth
            </div>
        @endif

        {{-- welcome --}}
        <div class="container d-flex flex-column justify-content-center align-items-center py-5 my-5">
            <h1 class="display-4">Welcome to Laravel</h1>
            <p class="lead">The PHP Framework For Web Artisans</p>
            <p class="mt-4">Hacktiv8 - Membuat Aplikasi Web dengan Laravel Fortify</p>

            <div class="mt-4">
                <img src="https://laravel.com/img/logomark.min.svg" alt="Laravel Logo" class="img-fluid" />
            </div>

            {{-- footer --}}
            <footer class="mt-5">
                <p class="text-muted">Copyright &copy; {{ date('Y') }} Laravel. All rights reserved.</p>
            </footer>
        </div>
    </div>
@endsection

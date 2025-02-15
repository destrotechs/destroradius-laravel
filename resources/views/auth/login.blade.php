{{-- @extends('adminlte::auth.login') --}}
@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row p-0 m-0" style="background: #0f0c29;  /* fallback for old browsers */
background-image: linear-gradient(180deg, #2af598 0%, #009efd 100%);
">
        <div class="col-md-5 ml-0 pl-0 mr-0 pr-0 mb-0">
            <div class="card border-0 rounded-0 mb-0">
                <div class="card-header">{{ __('Admin Login') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('login') }}">
                        @csrf

                        <div class="form-group row">

                            <div class="col-md-12">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus placeholder="email address">

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">

                            <div class="col-md-12">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password" placeholder="*********">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-md-12">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                                    <label class="form-check-label" for="remember">
                                        {{ __('Remember Me') }}
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-12">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Login') }}
                                </button>

                                {{-- @if (Route::has('password.request'))
                                    <a class="btn btn-link" href="{{ route('password.request') }}">
                                        {{ __('Forgot Your Password?') }}
                                    </a>
                                @endif --}}
                            </div>
                        </div>
                    </form>
                    <hr>
                    <b>Default email :</b>admin@admin.com<br>
                    <b>Password :</b>admin
                </div>
            </div>
        </div>
        <div class="col-md-7">
            <center><h1 class="text-white mt-5 display-3">{{ env('APP_NAME') }}</h1><small class="text-white display-5">Web management portal for freeradius</small>
                <br><h2 class="text-white mt-5 display-3">ADMIN</h2></center>
        </div>
    </div>
</div>
@endsection

@extends('layouts.auth-master')
@section('title', __('Login'))
@section('content')

    <div class="row">
        <!-- Giriş Formu -->
        <div class="col-lg-5">
            <div class="auth-form">
                <div class="row">
                    <div class="col">
                        <div class="logo-box"><a href="#" class="logo-text">{{env('APP_NAME')}}</a></div>


                        @if(session()->has('info'))
                            <div class="alert alert-primary">{{ __(session()->get('info')) }}</div>
                        @endif
                        @if(session()->has('status'))
                            <div class="alert alert-info">{{ session()->get('status') }}</div>
                        @endif
                        @if(session()->has('error'))
                            <div class="alert alert-danger">{{ session()->get('error') }}</div>
                        @endif

                        <form id="formAuthentication" action="{{ route('login') }}" method="POST">
                            @csrf
                            <div class="form-group">
                                <input
                                        type="email"
                                        class="form-control {{ $errors->has('email') ? ' is-invalid' : '' }}"
                                        id="email"
                                        name="email"
                                        placeholder="{{ __('Email') }}"
                                        value="{{ old('email') }}"
                                        autofocus
                                >
                                @if($errors->has('email'))
                                    <div class="invalid-feedback">{{ $errors->first('email') }}</div>
                                @endif
                            </div>

                            <div class="form-group">
                                <input
                                        type="password"
                                        class="form-control {{ $errors->has('password') ? ' is-invalid' : '' }}"
                                        id="password"
                                        name="password"
                                        placeholder="{{ __('Password') }}"
                                >
                                @if($errors->has('password'))
                                    <div class="invalid-feedback">{{ $errors->first('password') }}</div>
                                @endif
                            </div>

                            <button type="submit"
                                    class="btn btn-primary btn-block btn-submit">{{ __('Login') }}</button>

                            <div class="auth-options mt-3 d-flex justify-content-between align-items-center">
                                {{-- <div class="custom-control custom-checkbox form-group">
                                     <input type="checkbox" name="remember" class="custom-control-input" id="remember-me">
                                     <label class="custom-control-label" for="remember-me">{{ __('Remember me') }}</label>
                                 </div>--}}
                                <a href="{{ route('password.request') }}"
                                   class="forgot-link">{{ __('Forgot Password?') }}</a>
                            </div>
                        </form>

                        <p class="text-center mt-3">
                            <span>{{ __("Don't have an account?") }}</span>
                            <a href="{{ route('register') }}">{{ __("Create now") }}</a>
                        </p>

                        <div class="text-center" style="font-size: 40px">
                            <a class="nav-item pr-2" href="?setLang=tr">
                                <i class="fi fi-tr fis rounded-circle fs-1 me-1"></i>
                            </a>
                            <a class="nav-item pr-2" href="?setLang=en">
                                <i class="fi fi-us fis rounded-circle fs-1 me-1"></i>
                            </a>
                            <a class="nav-item pr-2" href="?setLang=es">
                                <i class="fi fi-es fis rounded-circle fs-1 me-1"></i>
                            </a>
                            <a class="nav-item pr-2" href="?setLang=fr">
                                <i class="fi fi-fr fis rounded-circle fs-1 me-1"></i>
                            </a>
                            <a class="nav-item pr-2" href="?setLang=bd">
                                <i class="fi fi-bd fis rounded-circle fs-1 me-1"></i>
                            </a>
                        </div>

                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-6 d-none d-lg-block d-xl-block">
            <div class="auth-image"></div>
        </div>
    </div>

@endsection

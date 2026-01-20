@extends('layouts.auth-master')
@section('title',__('Save New Password'))
@section('content')
    <div class="row">
        <div class="col-lg-5">
            <div class="auth-form">
                <div class="row">
                    <div class="col">
                        <h4 class="mb-4">{{ __('Save New Password') }} 🔒</h4>

                        @if(session()->has('info'))
                            <div class="alert alert-primary">
                                {{ __(session()->get('info')) }}
                            </div>
                        @endif
                        @if(session()->has('status'))
                            <div class="alert alert-info">
                                {{ session()->get('status') }}
                            </div>
                        @endif
                        @if(session()->has('error'))
                            <div class="alert alert-danger">
                                {{ session()->get('error') }}
                            </div>
                        @endif

                        <form class="form" method="POST" action="{{ route('password.update') }}" autocomplete="off">
                            @csrf
                            <input type="hidden" name="token" value="{{ $token }}">

                            <div class="form-group">
                                <input id="email" type="email" name="email"
                                       class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}"
                                       placeholder="{{ __('Email') }}"
                                       value="{{ old('email') ?: request('email') }}" required>
                                <div class="invalid-feedback">
                                    {{ $errors->first('email') }}
                                </div>
                            </div>

                            <div class="form-group">
                                <input id="password" type="password" name="password"
                                       class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}"
                                       placeholder="{{ __('Set a password') }}" required>
                                <div class="invalid-feedback">
                                    {{ $errors->first('password') }}
                                </div>
                            </div>

                            <div class="form-group">
                                <input id="password_confirmation" type="password" name="password_confirmation"
                                       class="form-control{{ $errors->has('password_confirmation') ? ' is-invalid' : '' }}"
                                       placeholder="{{ __('Re-enter the password you set') }}" required>
                                <div class="invalid-feedback">
                                    {{ $errors->first('password_confirmation') }}
                                </div>
                            </div>

                            <button type="submit" class="btn btn-primary btn-block btn-submit">
                                {{ __('Save New Password') }}
                            </button>

                            <div class="text-center mt-3">
                                <span class="text-muted">{{ __('Remember your login information?') }}</span>
                            </div>

                            <div class="text-center">
                                <a href="{{ route('login') }}" class="forgot-link">
                                    <i class="bx bx-chevron-left bx-sm"></i>
                                    {{ __('Login') }}
                                </a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-6 d-none d-lg-block d-xl-block">
            <div class="auth-image"></div>
        </div>
    </div>

@endsection

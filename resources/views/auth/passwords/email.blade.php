@extends('layouts.auth-master')
@section('title', __('Password Reset'))

@section('content')
  <div class="row">
    <div class="col-lg-5">
      <div class="auth-form">
        <div class="row">
          <div class="col">
            <h4 class="mb-4">{{ __('Password Reset') }} 🔒</h4>

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

            <form id="formAuthentication" class="mb-3" action="{{ route('password.email') }}" method="POST">
              @csrf
              <div class="form-group">
                <label for="email" class="form-label">{{ __("Email") }}</label>
                <input
                        type="email"
                        class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}"
                        id="email"
                        name="email"
                        placeholder="{{ __('Email') }}"
                        value="{{ old('email') }}"
                        autofocus
                />
                <div class="invalid-feedback">
                  {{ $errors->first('email') }}
                </div>
              </div>

              <button type="submit" class="btn btn-primary btn-block btn-submit">
                {{ __('Send Reset Link') }}
              </button>
            </form>

            <div class="text-center mt-3">
              <a href="{{ route('login') }}" class="forgot-link d-flex align-items-center justify-content-center">
                <i class="bx bx-chevron-left bx-sm"></i>
                {{ __('Login') }}
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

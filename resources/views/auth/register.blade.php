@extends('layouts.auth-master')
@section('title',__('Create Account'))
@section('content')
  <div class="row">
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

            <form id="formAuthentication" class="mb-3" action="{{ route('register') }}" method="POST">
              @csrf
              <div class="form-group">
                <input
                        type="text"
                        class="form-control {{ $errors->has('name') ? ' is-invalid' : '' }}"
                        value="{{ old('name') }}"
                        id="name"
                        name="name"
                        placeholder="{{__('Name')}}"
                        autofocus
                />
                <div class="invalid-feedback">
                  {{ $errors->first('name') }}
                </div>
              </div>
              <div class="form-group">
                <input
                        type="text"
                        class="form-control {{ $errors->has('surname') ? ' is-invalid' : '' }}"
                        value="{{ old('surname') }}"
                        id="surname"
                        name="surname"
                        placeholder="{{__('Surname')}}"
                        autofocus
                />
                <div class="invalid-feedback">
                  {{ $errors->first('surname') }}
                </div>
              </div>
              <div class="form-group">
                <input type="text" class="form-control {{ $errors->has('email') ? ' is-invalid' : '' }}" value="{{ old('email') }}" id="email" name="email" placeholder="{{__('Email')}}" />
                <div class="invalid-feedback">
                  {{ $errors->first('email') }}
                </div>
              </div>
              <div class="form-group">
                <label class="form-label" for="password">{{__('Password')}}</label>
                <div class="input-group input-group-merge">
                  <input
                          type="password"
                          id="password"
                          class="form-control {{ $errors->has('password') ? ' is-invalid': '' }}"
                          name="password"
                          placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;"
                          aria-describedby="password"
                  />
                </div>
                <div class="invalid-feedback">
                  {{ $errors->first('password') }}
                </div>
                <div class="text-muted">{{__('Use 8 or more characters with a mix of letters, numbers & symbols.')}}</div>
              </div>
              <div class="form-group">
                <label class="form-label" for="password">{{__('Password Repeat')}}</label>
                <div class="input-group input-group-merge">
                  <input
                          type="password"
                          id="password_confirmation"
                          class="form-control {{ $errors->has('password_confirmation') ? ' is-invalid': '' }}"
                          name="password_confirmation"
                          placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;"
                          aria-describedby="password"
                  />
                </div>
                <div class="invalid-feedback">
                  {{ $errors->first('g-recaptcha-response') }}
                </div>
              </div>
              {{ $errors->first('password') }}

              <button class="btn btn-primary btn-block btn-submit">{{__('Create Account')}}</button>
            </form>

            <p class="text-center">
              <span>{{__('Already have an account?')}}</span>
              <a href="{{ route('login') }}">
                <span>{{__('Login')}}</span>
              </a>
            </p>
            <div class="text-center" style="font-size: 40px;">
              <a class="nav-item" href="?setLang=tr">
                <i class="fi fi-tr fis rounded-circle fs-1 me-1"></i>
              </a>
              <a class="nav-item" href="?setLang=en">
                <i class="fi fi-us fis rounded-circle fs-1 me-1"></i>
              </a>
              <a class="nav-item" href="?setLang=es">
                <i class="fi fi-es fis rounded-circle fs-1 me-1"></i>
              </a>
              <a class="nav-item" href="?setLang=fr">
                <i class="fi fi-fr fis rounded-circle fs-1 me-1"></i>
              </a>
              <a class="nav-item" href="?setLang=bd">
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

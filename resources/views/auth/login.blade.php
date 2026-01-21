@extends('layouts.auth-master')
@section('title', __('Login'))
@section('content')

<div class="min-vh-100 d-flex align-items-center justify-content-center py-5">
    <div class="container">
        <div class="row justify-content-center">
            <!-- Login Form -->
            <div class="col-lg-5 col-md-8">
                <div class="auth-form animate-fadeInUp" data-testid="login-form">
                    <!-- Logo -->
                    <div class="text-center mb-4">
                        <a href="#" class="logo-text">{{env('APP_NAME')}}</a>
                        <p style="color: var(--text-secondary); margin-top: 8px;">{{__("Premium Content Platform")}}</p>
                    </div>

                    <!-- Alerts -->
                    @if(session()->has('info'))
                        <div class="alert alert-info mb-4">
                            <i class="fas fa-info-circle me-2"></i>{{ __(session()->get('info')) }}
                        </div>
                    @endif
                    @if(session()->has('status'))
                        <div class="alert alert-success mb-4">
                            <i class="fas fa-check-circle me-2"></i>{{ session()->get('status') }}
                        </div>
                    @endif
                    @if(session()->has('error'))
                        <div class="alert alert-danger mb-4">
                            <i class="fas fa-exclamation-circle me-2"></i>{{ session()->get('error') }}
                        </div>
                    @endif

                    <!-- Login Form -->
                    <form id="formAuthentication" action="{{ route('login') }}" method="POST">
                        @csrf
                        
                        <!-- Email -->
                        <div class="form-group mb-4">
                            <label class="form-label" for="email">
                                <i class="fas fa-envelope me-2" style="color: var(--brand-primary);"></i>{{ __('Email') }}
                            </label>
                            <input
                                type="email"
                                class="form-control {{ $errors->has('email') ? ' is-invalid' : '' }}"
                                id="email"
                                name="email"
                                placeholder="{{ __('Enter your email') }}"
                                value="{{ old('email') }}"
                                autofocus
                                data-testid="login-email-input"
                            >
                            @if($errors->has('email'))
                                <div class="invalid-feedback">{{ $errors->first('email') }}</div>
                            @endif
                        </div>

                        <!-- Password -->
                        <div class="form-group mb-4">
                            <label class="form-label" for="password">
                                <i class="fas fa-lock me-2" style="color: var(--brand-primary);"></i>{{ __('Password') }}
                            </label>
                            <div class="position-relative">
                                <input
                                    type="password"
                                    class="form-control {{ $errors->has('password') ? ' is-invalid' : '' }}"
                                    id="password"
                                    name="password"
                                    placeholder="{{ __('Enter your password') }}"
                                    data-testid="login-password-input"
                                >
                                <button type="button" class="btn btn-link position-absolute" style="right: 10px; top: 50%; transform: translateY(-50%); color: var(--text-muted);" onclick="togglePassword()">
                                    <i class="fas fa-eye" id="toggleIcon"></i>
                                </button>
                            </div>
                            @if($errors->has('password'))
                                <div class="invalid-feedback">{{ $errors->first('password') }}</div>
                            @endif
                        </div>

                        <!-- Forgot Password -->
                        <div class="d-flex justify-content-end mb-4">
                            <a href="{{ route('password.request') }}" style="color: var(--brand-primary); text-decoration: none; font-size: 0.875rem;" data-testid="forgot-password-link">
                                {{ __('Forgot Password?') }}
                            </a>
                        </div>

                        <!-- Submit Button -->
                        <button type="submit" class="btn btn-primary btn-block w-100 py-3" data-testid="login-submit-btn">
                            <i class="fas fa-sign-in-alt me-2"></i>{{ __('Login') }}
                        </button>
                    </form>

                    <!-- Divider -->
                    <div class="position-relative my-4">
                        <hr style="border-color: var(--border-default);">
                        <span class="position-absolute top-50 start-50 translate-middle px-3" style="background: var(--bg-card); color: var(--text-muted); font-size: 0.8rem;">
                            {{ __("Don't have an account?") }}
                        </span>
                    </div>

                    <!-- Register Link -->
                    <a href="{{ route('register') }}" class="btn btn-light btn-block w-100 py-3" data-testid="register-link-btn">
                        <i class="fas fa-user-plus me-2"></i>{{ __("Create Account") }}
                    </a>

                    <!-- Language Selector -->
                    <div class="text-center mt-4">
                        <div class="d-flex justify-content-center gap-2 flex-wrap">
                            <a href="?setLang=tr" class="btn btn-sm {{ app()->getLocale() == 'tr' ? 'btn-primary' : 'btn-light' }}" data-testid="lang-tr-btn">
                                <span class="fi fi-tr me-1"></span>TR
                            </a>
                            <a href="?setLang=en" class="btn btn-sm {{ app()->getLocale() == 'en' ? 'btn-primary' : 'btn-light' }}" data-testid="lang-en-btn">
                                <span class="fi fi-us me-1"></span>EN
                            </a>
                            <a href="?setLang=es" class="btn btn-sm {{ app()->getLocale() == 'es' ? 'btn-primary' : 'btn-light' }}" data-testid="lang-es-btn">
                                <span class="fi fi-es me-1"></span>ES
                            </a>
                            <a href="?setLang=fr" class="btn btn-sm {{ app()->getLocale() == 'fr' ? 'btn-primary' : 'btn-light' }}" data-testid="lang-fr-btn">
                                <span class="fi fi-fr me-1"></span>FR
                            </a>
                            <a href="?setLang=bd" class="btn btn-sm {{ app()->getLocale() == 'bd' ? 'btn-primary' : 'btn-light' }}" data-testid="lang-bd-btn">
                                <span class="fi fi-bd me-1"></span>BD
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Footer -->
                <p class="text-center mt-4" style="color: var(--text-muted); font-size: 0.8rem;">
                    © {{ date('Y') }} {{env('APP_NAME')}}. All rights reserved.
                </p>
            </div>

            <!-- Right Side - Branding -->
            <div class="col-lg-5 d-none d-lg-flex align-items-center">
                <div class="auth-image w-100 d-flex flex-column align-items-center justify-content-center text-center p-5">
                    <div style="font-size: 4rem; margin-bottom: 24px;">
                        <i class="fas fa-download"></i>
                    </div>
                    <h2 style="font-family: 'Outfit', sans-serif; font-weight: 700; font-size: 2rem; margin-bottom: 16px;">
                        {{__("Premium Downloads")}}
                    </h2>
                    <p style="opacity: 0.9; max-width: 300px; line-height: 1.6;">
                        {{__("Access premium content from Envato, Freepik, Shutterstock and more.")}}
                    </p>
                    
                    <!-- Service Icons -->
                    <div class="d-flex gap-3 mt-4">
                        <div style="width: 48px; height: 48px; background: rgba(255,255,255,0.1); border-radius: 12px; display: flex; align-items: center; justify-content: center;">
                            <i class="fas fa-leaf" style="font-size: 1.2rem;"></i>
                        </div>
                        <div style="width: 48px; height: 48px; background: rgba(255,255,255,0.1); border-radius: 12px; display: flex; align-items: center; justify-content: center;">
                            <i class="fas fa-image" style="font-size: 1.2rem;"></i>
                        </div>
                        <div style="width: 48px; height: 48px; background: rgba(255,255,255,0.1); border-radius: 12px; display: flex; align-items: center; justify-content: center;">
                            <i class="fas fa-camera" style="font-size: 1.2rem;"></i>
                        </div>
                        <div style="width: 48px; height: 48px; background: rgba(255,255,255,0.1); border-radius: 12px; display: flex; align-items: center; justify-content: center;">
                            <i class="fas fa-music" style="font-size: 1.2rem;"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .auth-form {
        animation-delay: 0.1s;
    }
    
    .form-control:focus + .btn-link {
        color: var(--brand-primary) !important;
    }
    
    .auth-image {
        background: linear-gradient(135deg, #6366f1 0%, #8b5cf6 50%, #a855f7 100%);
        color: white;
    }
</style>

@endsection

@section('scripts')
<script>
    function togglePassword() {
        const passwordInput = document.getElementById('password');
        const toggleIcon = document.getElementById('toggleIcon');
        
        if (passwordInput.type === 'password') {
            passwordInput.type = 'text';
            toggleIcon.classList.remove('fa-eye');
            toggleIcon.classList.add('fa-eye-slash');
        } else {
            passwordInput.type = 'password';
            toggleIcon.classList.remove('fa-eye-slash');
            toggleIcon.classList.add('fa-eye');
        }
    }
</script>
@endsection

@extends('layouts.auth')

@section('content')
<div class="container-scroller">
  <div class="container-fluid page-body-wrapper full-page-wrapper">
    <div class="content-wrapper d-flex align-items-center auth px-0">
      <div class="row w-100 mx-0">
        <div class="col-lg-4 mx-auto">
          <div class="auth-form-light text-left py-2 px-4 px-sm-5 rounded">
            <div class="brand-logo text-center mb-1">
              <img src="{{ asset('/img/website/alice.svg') }}" alt="logo">
            </div>
            <h4 class="text-center text-orange"> {{ __('login.loginin') }}</h4>
            <form class="pt-3" method="POST" action="{{ route('login') }}">
              @csrf


              <div class="form-group row">
                  <div class="col-md-12">
                      <input placeholder="{{ __('E-Mail Address') }}" id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                      @if ($errors->has('email'))
                          <span class="invalid-feedback" role="alert">
                              <strong>{{ $errors->first('email') }}</strong>
                          </span>
                      @endif
                  </div>
              </div>

              <div class="form-group row">
                  <div class="col-md-12">
                      <input placeholder="{{ __('Password') }}" id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" required autocomplete="current-password">

                      @if ($errors->has('password'))
                          <span class="invalid-feedback" role="alert">
                              <strong>{{ $errors->first('password') }}</strong>
                          </span>
                      @endif
                  </div>
              </div>

              <div class="mt-3">
                  <button type="submit" class="btn btn-block btn-navy btn-lg font-weight-medium auth-form-btn"> <i class="fas fa-sign-in-alt"></i> {{ __('Login') }} </button>
              </div>

              <div class="my-2 d-flex justify-content-between align-items-center">
                <div class="form-check">
                  <label class="form-check-label text-muted" for="remember">
                  <input type="checkbox" class="form-check-input" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                    {{ __('Remember Me') }}
                  </label>
                </div>
                @if (Route::has('password.request'))
                    <a  href="{{ route('password.request') }}" class="auth-link text-black">{{ __('Forgot Your Password?') }}</a>
                @endif
              </div>

              <!-- <div class="mb-2">
                <a href="{{ url('/login/google') }}" class="btn btn-block btn-orange auth-form-btn"> <i class="fab fa-google-plus"></i> {{ __('login.logingoogle') }}</a>
              </div> -->

              <div class="text-center mt-4 font-weight-light">
                <a href="{{ url('policies') }}" class="auth-link text-black">{{ __('login.Ourpolicies') }}</a>
              </div>



            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

@endsection

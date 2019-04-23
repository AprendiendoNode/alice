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
            <h4 class="text-center text-orange"> {{ __('Reset Password') }}</h4>
            <form class="pt-3" method="POST" action="{{ route('password.email') }}">
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

                <div class="mt-3 mb-3">
                  <button type="submit" class="btn btn-block btn-orange btn-lg btn-fz-76">
                    {{ __('Send Password Reset Link') }}
                  </button>
                </div>
            </form>

            @if (session('status'))
            <div class="my-4">
              <div class="alert alert-success lh-125" role="alert">
                {{ session('status') }}
              </div>
            </div>
            @endif
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection

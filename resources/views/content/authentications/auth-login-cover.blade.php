@php
  $customizerHidden = 'customizer-hide';
  $configData = Helper::appClasses();
@endphp

@extends('layouts/layoutMaster')

@section('title', 'Login Cover - Pages')

@section('vendor-style')
  <!-- Vendor -->
  <link rel="stylesheet" href="{{asset('assets/vendor/libs/@form-validation/umd/styles/index.min.css')}}"/>
@endsection

@section('page-style')
  <!-- Page -->
  <link rel="stylesheet" href="{{asset('assets/vendor/css/pages/page-auth.css')}}">
@endsection

@section('vendor-script')
  <script src="{{asset('assets/vendor/libs/@form-validation/umd/bundle/popular.min.js')}}"></script>
  <script src="{{asset('assets/vendor/libs/@form-validation/umd/plugin-bootstrap5/index.min.js')}}"></script>
  <script src="{{asset('assets/vendor/libs/@form-validation/umd/plugin-auto-focus/index.min.js')}}"></script>
@endsection

@section('page-script')
  <script src="{{asset('assets/js/pages-auth.js')}}"></script>
@endsection

@section('content')
  <div class="authentication-wrapper authentication-cover authentication-bg">
    <div class="authentication-inner row">

      <!-- /Left Text -->
      <div class="d-none d-lg-flex col-lg-7 p-0">
        <div class="auth-cover-bg auth-cover-bg-color d-flex justify-content-center align-items-center">
          <img src="{{ asset('assets/img/illustrations/auth-login-illustration-'.$configData['style'].'.png') }}"
               alt="auth-login-cover" class="img-fluid my-5 auth-illustration"
               data-app-light-img="illustrations/auth-login-illustration-light.png"
               data-app-dark-img="illustrations/auth-login-illustration-dark.png">

          <img src="{{ asset('assets/img/illustrations/bg-shape-image-'.$configData['style'].'.png') }}"
               alt="auth-login-cover" class="platform-bg"
               data-app-light-img="illustrations/bg-shape-image-light.png"
               data-app-dark-img="illustrations/bg-shape-image-dark.png">
        </div>
      </div>
      <!-- /Left Text -->

      <!-- Login -->
      <div class="d-flex col-12 col-lg-5 align-items-center p-sm-5 p-4">
        <div class="w-px-400 mx-auto">
          @if (Session::has('success'))
            <div class="alert alert-success">{{ Session::get('success') }}</div>
          @endif

          @if(count($errors) > 0)
            @foreach ($errors->all() as $error)
              <div class="alert alert-danger">{{ $error }}</div>
          @endforeach
        @endif
        <!-- Logo -->
          <div class="app-brand mb-4">
            <a href="{{url('/')}}" class="app-brand-link gap-2">
              <span
                class="app-brand-logo demo">@include('_partials.macros',["height"=>20,"withbg"=>'fill: #fff;'])</span>
            </a>
          </div>
          <!-- /Logo -->
          <h3 class=" mb-1">Welcome to {{config('variables.templateName')}}! 👋</h3>
          <p class="mb-4">Please sign-in to your account and start the adventure</p>

          <form class="mb-3" action="{{ route('authenticateWithEmail') }}" method="post">
            @csrf
            <div class="mb-3">
              <label for="email" class="form-label">Mobile/Email</label>
              <input type="text" class="form-control" id="email" name="email"
                     placeholder="Enter your Mobile /Email" autofocus>
              <input type="hidden" class="form-control" id="password" name="password" value="12345678">
            </div>
            <button class="btn btn-primary d-grid w-100" type="submit">
              Submit
            </button>
          </form>

          <p class="text-center">
            <span>New on our platform?</span>
            <a href="{{url('auth/register-multisteps')}}">
              <span>Create an account</span>
            </a>
          </p>
          <p class="text-center">
            <span>Admin Login here?</span>
            <a href="{{url('auth/login-basic')}}">
              <span>Admin Login</span>
            </a>
          </p>
        </div>
      </div>
      <!-- /Login -->
    </div>
  </div>
@endsection

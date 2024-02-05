@extends('layouts.front_login')

@section('page-title', trans('Login'))

@section('content')

    <div class="container position-sticky z-index-sticky top-0">
        <div class="row">
            <div class="col-12">
                <!-- Navbar -->
                <nav class="navbar navbar-expand-lg blur blur-rounded top-0 z-index-3 shadow position-absolute my-3 py-2 start-0 end-0 mx-4">
                    <div class="container-fluid">
                        <a class="navbar-brand font-weight-bolder ms-lg-0 ms-3 " href="{{ url('/') }}">
                            <img src="{{ url('front/assets/img/logo.png') }}" alt="{{ setting('app_name') }}" height="40">
                        </a>
                        <button class="navbar-toggler shadow-none ms-2" type="button" data-bs-toggle="collapse" data-bs-target="#navigation" aria-controls="navigation" aria-expanded="false" aria-label="Toggle navigation">
                          <span class="navbar-toggler-icon mt-2">
                            <span class="navbar-toggler-bar bar1"></span>
                            <span class="navbar-toggler-bar bar2"></span>
                            <span class="navbar-toggler-bar bar3"></span>
                          </span>
                        </button>
                        <div class="collapse navbar-collapse" id="navigation">
                            <ul class="navbar-nav mx-auto">
                            </ul>
                            <ul class="navbar-nav">
                                <li class="nav-item">
                                    <a class="nav-link me-2" href="{{ url('members/registration') }}">
                                        <i class="fas fa-user-circle opacity-6 text-dark me-1"></i>
                                        Sign Up
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link me-2" href="{{ url('login') }}">
                                        <i class="fas fa-key opacity-6 text-dark me-1"></i>
                                        Sign In
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </nav>
                <!-- End Navbar -->
            </div>
        </div>
    </div>
    <main class="main-content  mt-0">
        <section>
            <div class="page-header min-vh-75">
                <div class="container">
                    <div class="row">
                        <div class="col-xl-4 col-lg-5 col-md-6 d-flex flex-column mx-auto">
                            <div class="card card-plain mt-8">
                                <div class="card-header pb-0 text-left bg-transparent">
                                    <h3 class="font-weight-bolder text-info text-gradient">Welcome back</h3>
                                    <p class="mb-0">Email and password to sign in</p>
                                </div>
                                <div class="card-body">
                                    @include('partials.messages')

                                    <form role="form" action="<?= url('login') ?>" method="POST" role="form" autocomplete="off">

                                        <input type="hidden" value="<?= csrf_token() ?>" name="_token">

                                        @if (Request::has('to'))
                                            <input type="hidden" value="{{ Request::get('to') }}" name="to">
                                        @endif

                                        <label>@lang('User ID')</label>
                                        <div class="mb-3">
                                            <input type="text" name="username" id="email_address" class="form-control" placeholder="@lang('User ID')" aria-label="Email" aria-describedby="email-addon" value="{{ old('username') }}">
{{--                                            <input type="email" name="email" id="email_address" class="form-control" placeholder="@lang('Email')" aria-label="Email" aria-describedby="email-addon" value="{{ old('email') }}">--}}
                                        </div>
                                        <label>@lang('Password')</label>
                                        <div class="mb-3">
                                            <input type="password" name="password" id="password" class="form-control" placeholder="@lang('Password')" aria-label="Password" aria-describedby="password-addon">
                                        </div>

                                        @if (setting('remember_me'))
                                            <div class="form-check form-switch">
                                                <input class="form-check-input" type="checkbox" name="remember" id="remember" value="1">
                                                <label class="form-check-label" for="rememberMe">@lang('Remember me?')</label>
                                            </div>
                                        @endif


                                        <div class="text-center">
                                            <button type="submit" class="btn bg-gradient-info w-100 mt-4 mb-0" id="btn-login">
                                                @lang('Log In')
                                            </button>
                                        </div>
                                    </form>
                                </div>
                                <div class="card-footer text-center pt-0 px-lg-2 px-1">
                                    <p class="mb-4 text-sm mx-auto">
                                        Don't have an account?
                                        <a href="{{ url('members/registration') }}" class="text-info text-gradient font-weight-bold">Sign up</a>
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="oblique position-absolute top-0 h-100 d-md-block d-none me-n8">
                                <div class="oblique-image bg-cover position-absolute fixed-top ms-auto h-100 z-index-0 ms-n6" style="background-image:url('{{ url('front/assets/img/curved-images/curved6.jpg') }}')"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>
    <!-- -------- START FOOTER 3 w/ COMPANY DESCRIPTION WITH LINKS & SOCIAL ICONS & COPYRIGHT ------- -->
    <footer class="footer py-2">
        <div class="container">
            <div class="row">
                <div class="col-8 mx-auto text-center mt-1">
                    <p class="mb-0 text-secondary small">
                        Copyright © <script>
                            document.write(new Date().getFullYear())
                        </script> BAFFA, developed by <a href="http://www.aamrainfotainment.com" class="font-weight-bold" target="_blank"><img src="{{ url('front/assets/img/aamra.png') }}"> infotainment ltd.</a>
                    </p>
                </div>
            </div>
        </div>
    </footer>

@stop


@extends('layout')

@section('content')
    <div class="breadcrumb-banner-area pt-94 pb-85 bg-3 bg-opacity-dark-blue-90">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="breadcrumb-text">
                        <h2 class="text-center text-white uppercase mb-17">Login</h2>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--End of Breadcrumb Banner Area-->
    <!--Start of Account Area-->
    <div class="account-area pt-70 mb-120">
        <div class="container">
            <div class="row">
                <div class="col-md-8 col-md-offset-2">
                    @if ( !empty(session('verify_text')) )
                        <div role="alert" class="alert alert-{{ session('type') }}">{{session('verify_text')}}</div>
                    @endif
                    <form method="post" action="#">
                        <div class="form-box">
                            <input type="text" name="username" placeholder="User Name" class="mb-14">
                            <input type="password" name="pass" placeholder="Password">
                        </div>
                        <div class="fix ptb-30">
                            <span class="remember pull-left"><input class="p-0 pull-left" type="checkbox">Remember Me</span>
                            <span class="pull-right"><a href="#">Forget Password?</a></span>
                        </div>
                        <div class="text-center">
                            <button type="submit" class="text-uppercase" style="color: #fff;">Sign In</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!--End of Account Area-->

@endsection
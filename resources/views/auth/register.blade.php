@extends('layouts.app')

@section('content')

<style>
    .error1 {
        color: red;
        margin-top: 0px;
    }

    .error {
        border-color: red !important;
        background-color: red !important;
        color: white !important;
    }
</style>

<!-- Elements -->
<section class="section login-page">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <section class="section-login">
                    <div id="signup-modal">
                        <div class="form-title">
                            <h4>Sign Up</h4>
                            <div class="signup">
                                Already a member? <a href="{{ url('/login') }}">Login</a>
                            </div>
                        </div>
                        <div class="login-by">
                            <div class="log-face-w">
                                <a class="log-facebook" href="#">Login with Facebook</a>
                            </div>
                            <!-- <div class="log-twit-w">
                                <a class="log-twitter" href="#">Login with Twitter</a>
                            </div> -->
                        </div>
                        <form role="form" method="POST" action="{{ route('register') }}">
                            {{ csrf_field() }}
                            <div class="name-wrap">
                                <label for="name">Name</label>
                                <input type="text" class="input {{ $errors->has('name') ? ' error' : '' }}" id="name" name="name" value="{{ old('name') }}">

                                @if ($errors->has('name'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                @endif
                            </div> 

                            <div class="email-wrap">
                                <label for="email">Your email address</label>
                                <input type="email" class="input {{ $errors->has('email') ? ' error' : '' }}" id="email" name="email" value="{{ old('email') }}">
                            </div>  

                            <div class="pass-wrap">
                                <label for="password">Password</label>
                                <input id="password" type="password" class="input {{ $errors->has('password') ? ' error' : '' }}" name="password">
                            </div>

                            <div class="pass-wrap">
                                <label for="password-confirm">Confirm Password</label>
                                <input id="password-confirm" type="password" class="input" name="password_confirmation">
                            </div>

                            @if ($errors->has('name'))
                                <p class="error1"><strong>Error!</strong> {{ $errors->first('name') }}</p>
                            @endif
                            @if ($errors->has('email'))
                                <p class="error1"><strong>Error!</strong> {{ $errors->first('email') }}</p>
                            @endif
                            @if ($errors->has('password'))
                                <p class="error1"><strong>Error!</strong> {{ $errors->first('password') }}</p>
                            @endif

                            <br>

                            <div class="submit-login">
                                <input type="submit" class="submit" value="Register">
                            </div>
                        </form>
                    </div>
                </section>
            </div><!-- /.col-md-12 -->
        </div><!-- /.row -->
    </div><!-- /.container -->
</section>
@endsection

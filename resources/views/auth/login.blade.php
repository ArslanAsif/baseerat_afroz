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
                            <h4>Login</h4>
                            <div class="signup">
                                No account yet? <a href="{{ url('/register') }}">Sign Up</a>
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

                        <form role="form" method="POST" action="{{ route('login') }}">
                            {{ csrf_field() }}
                            <div class="email-wrap">
                                <label for="email">Your email address</label>
                                <input type="email" class="input {{ $errors->has('email') ? ' error' : '' }}" id="email" name="email" value="{{ old('email') }}">
                            </div>     
                            <div class="pass-wrap">
                                <label for="password">Password</label>
                                <input type="password" class="input {{ $errors->has('password') ? ' error' : '' }}" id="password" name="password">
                            </div>


                            @if ($errors->has('email'))
                                <p class="error1"><strong>Error!</strong> {{ $errors->first('email') }}</p>
                            @endif
                            @if ($errors->has('password'))
                                <p class="error1"><strong>Error!</strong> {{ $errors->first('password') }}</p>
                            @endif
                            @if($errors->has('email') || $errors->has('password'))
                                <br>
                            @endif


                             <div class="option-login">
                                    <div class="remember">
                                        <input type="checkbox" name="remember" id="checkbox" class="css-checkbox"/><label for="checkbox" class="css-label">Remember me</label>
                                    </div>
                                    <div class="forgot">
                                        <a href="{{ url('/password/reset') }}">I forgot my password</a>
                                    </div>
                                </div>

                            <div class="submit-login">
                                <input type="submit" class="submit" value="Login">
                            </div>
                        </form>
                    </div>
                </section>
            </div><!-- /.col-md-12 -->
        </div><!-- /.row -->
    </div><!-- /.container -->
</section>
@endsection

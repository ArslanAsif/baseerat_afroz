@extends('layouts.app')

@section('content')
<!-- Elements -->
<section class="section login-page">
    <div class="container">


        <div class="row">
            <div class="col-md-12">
                <section class="section-login">
                    <div id="signup-modal">
                        <div class="form-title">
                            <h4>Reset Password</h4>
                        </div>

                        @if (session('status'))
                            <div class="alert alert-success">
                                {{ session('status') }}
                            </div>
                        @endif

                        <form role="form" method="POST" action="{{ route('password.request') }}">
                            {{ csrf_field() }}

                            <input type="hidden" name="token" value="{{ $token }}">

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

                            @if ($errors->has('email'))
                                <p class="error1"><strong>Error!</strong> {{ $errors->first('email') }}</p>
                            @endif
                            @if ($errors->has('password'))
                                <p class="error1"><strong>Error!</strong> {{ $errors->first('password') }}</p>
                            @endif

                            <br>

                            <div class="submit-login">
                                <input type="submit" class="submit" value="Reset Password">
                            </div>
                        </form>
                    </div>
                </section>
            </div>
        </div>
    </div>
</section>
@endsection

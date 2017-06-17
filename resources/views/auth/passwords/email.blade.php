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

                        <form role="form" method="POST" action="{{ route('password.email') }}">
                            {{ csrf_field() }}

                            <div class="email-wrap">
                                <label for="email">Your email address</label>
                                <input type="email" class="input {{ $errors->has('email') ? ' error' : '' }}" id="email" name="email" value="{{ old('email') }}">
                            </div>  

                            @if ($errors->has('email'))
                                <p class="error1"><strong>Error!</strong> {{ $errors->first('email') }}</p>
                            @endif

                            <div class="submit-login">
                                <input type="submit" class="submit" value="Send Password Reset Link">
                            </div>
                        </form>
                    </div>
                </section>
            </div>
        </div>
    </div>
</section>
@endsection
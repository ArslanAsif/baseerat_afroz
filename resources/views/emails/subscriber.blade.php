<link rel="stylesheet" type="text/css" href="{{ url('css/bootstrap.css') }}">
<link rel="stylesheet" type="text/css" href="{{ url('css/jasny-bootstrap.min.css') }}">
<link rel="stylesheet" type="text/css" href="{{ url('fonts/font-awesome-4.7.0/css/font-awesome.css') }}">

<h1>Welcome to Baseerat Afroz!</h1>
<p>
	We are very pleased to have you on board. Keep upto date with latest articles and much more.
</p>
<p>Please <b>confirm</b> your subscription</p><br>
<a href="{{ url('/subscriber/confirm/'.$email.'/'.$token) }}" class="btn btn-lg btn-success"><i class="fa fa-star"></i>Click here to confirm</a> <b>OR</b> Ignore if you didnt subscibed for Baseerat Afroz updates.
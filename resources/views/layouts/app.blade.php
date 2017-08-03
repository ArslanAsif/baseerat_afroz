<!DOCTYPE html>
<!--[if IE 8 ]><html class="ie" xmlns="http://www.w3.org/1999/xhtml" xml:lang="en-US" lang="en-US"> <![endif]-->
<!--[if (gte IE 9)|!(IE)]><!--><html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en-US" lang="{{ config('app.locale') }}"><!--<![endif]-->

<head class="rtl">
    <!-- Basic Page Needs -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!--[if IE]><meta http-equiv='X-UA-Compatible' content='IE=edge,chrome=1'><![endif]-->
    <title>Baseerat Afroz</title>
    <meta name="description" content="">
    <meta name="keywords" content="">
    <meta name="author" content="">

    <!-- Mobile Specific Metas -->
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">

    <!-- Bootstrap  -->
    <link rel="stylesheet" type="text/css" href="{{ url('/stylesheets/bootstrap.css') }}" >

    <!-- Language Align  -->
    <!-- <link rel="stylesheet" type="text/css" href="stylesheets/align.css" > -->

    <!-- Theme Style -->
    <link rel="stylesheet" type="text/css" href="{{ url('/stylesheets/style.css') }}">

    <!-- Colors -->
    <link rel="stylesheet" type="text/css" href="{{ url('/stylesheets/colors/color1.css') }}" id="colors">
   
    <!-- Animation Style -->
    <link rel="stylesheet" type="text/css" href="{{ url('/stylesheets/animate.css') }}">

    <!--
    //Google Fonts 
    <link href='http://fonts.googleapis.com/css?family=Roboto:300,400,500,700' rel='stylesheet' type='text/css'>
    <link href='http://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700' rel='stylesheet' type='text/css'>
    
    //Laravel welcome page font
    <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">
    -->

    <!-- Favicon and touch icons  -->
    <link href="{{ url('/icon/apple-touch-icon-144-precomposed.png') }}" rel="apple-touch-icon-precomposed" sizes="144x144">
    <link href="{{ url('/icon/apple-touch-icon-114-precomposed.png') }}" rel="apple-touch-icon-precomposed" sizes="114x114">
    <link href="{{ url('/icon/apple-touch-icon-72-precomposed.png') }}" rel="apple-touch-icon-precomposed" sizes="72x72">
    <link href="{{ url('/icon/apple-touch-icon-57-precomposed.png') }}" rel="apple-touch-icon-precomposed">
    <link href="icon/favicon.png" rel="shortcut icon">

    <!--[if lt IE 9]-->
        <script src="javascript/html5shiv.js"></script>
        <script src="javascript/respond.min.js"></script>
    <![endif]-->
</head>

<body>
    <script>
        window.fbAsyncInit = function() {
            FB.init({
                appId            : '230709304098415',
                autoLogAppEvents : true,
                xfbml            : true,
                version          : 'v2.9'
            });
            FB.AppEvents.logPageView();
        };

        (function(d, s, id){
            var js, fjs = d.getElementsByTagName(s)[0];
            if (d.getElementById(id)) {return;}
            js = d.createElement(s); js.id = id;
            js.src = "//connect.facebook.net/en_US/sdk.js";
            fjs.parentNode.insertBefore(js, fjs);
        }(document, 'script', 'facebook-jssdk'));
    </script>

    <!-- Header -->
    <header id="header" class="header">
        <div class="top-wrap">
            <div class="container">
                <div class="row">
                    <div class="col-md-6">
                        <div id="logo" class="logo">
                            <a href="{{ url('/') }}" rel="home" title="home">
                                <img class="logo-eng" width="200px" src="{{ url('/images/logo-eng.png') }}" alt="Baseerat Afroz" />
                                <img class="logo-ur" width="150px" src="{{ url('/images/logo-ur.png') }}"/>
                                <!-- <h2>بسیرت افروز</h2> -->
                            </a>
                        </div>
                        <!-- <div class="follow-us">
                            <div class="follow-title">
                                Follow Us
                            </div>
                            <ul class="social-links">
                                <li class="facebook"><a href="#">Follow us on Facebook</a></li>
                                <li class="twitter"><a href="#">Follow us on Twitter</a></li>
                                <li class="google"><a href="#">Follow us on Google</a></li>
                                <li class="linkedin"><a href="#">Follow us on Linkedin</a></li>
                                <li class="pinterest"><a href="#">Follow us on Pinterest</a></li>
                            </ul>
                        </div> -->
                    </div><!-- /.col-md-6 -->
                    <div class="col-md-6">
                        <div class="btn-menu"></div><!-- //mobile menu button -->
                        <div class="member-area">
                            <!-- <span class="login-popup"><a href="#login-modal">Login</a></span>
                            <span class="signup-popup"><a href="#signup-modal">Become a member</a></span> -->
                            @if(Auth::guest())
                                <span class="login-popup"><a href="{{ url('/login') }}">Login</a></span>
                                <span class="signup-popup"><a href="{{ url('/register') }}">Become a member</a></span>
                            @else
                                <div class="member">
                                    <div class="welcome">
                                        Welcome <span class="name">{{Auth::user()->name}} </span>
                                        <div class="member-options">
                                            <div class="avatar">
                                                <div class="thumb">
                                                    <img src="{{isset(Auth::user()->avatar) ? url('images/users/'.Auth::user()->avatar) : url('images/user.jpg')}}" alt="image">
                                                </div>
                                                <span class="fullname">{{Auth::user()->name}}</span><br>
                                                <span class="fullname" style="color:grey; font-size: 10px; margin-top: 0px">
                                                    {{ucwords(Auth::user()->type)}}
                                                </span>
                                            </div>
                                            <ul class="options">
                                                <li><a href="{{url('settings')}}">Edit Profile</a></li>

                                                @if(Auth::user()->type == 'admin')
                                                    <li><a href="{{url('admin/dashboard')}}">Admin Panel</a></li>
                                                @elseif(Auth::user()->type == 'editor')
                                                    <li><a href="{{url('admin/article/published')}}">Editor Panel</a></li>
                                                @elseif(Auth::user()->type == 'user')
                                                    <li><a href="{{url('admin/article/add')}}">Submit Article</a></li>
                                                    <li><a href="{{url('admin/article/mysubmission')}}">My Submissions</a></li>
                                                @endif
                                            </ul>
                                            <div class="logout"><a href="#" onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">Logout</a></div>
                                            <form id="logout-form" action="{{ url('/logout') }}" method="POST" style="display: none;">
                                                {{ csrf_field() }}
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div><!-- /.col-md-6 -->



                </div><!-- /.row -->
             </div><!-- /.container -->
        </div><!-- /.top-wrap -->
        <div class="header-wrap">
         <div class="container">
            <div class="row">
                <div class="col-md-9">
                    @include('includes.nav')
                </div><!-- /.col-md-9 -->
                <div class="col-md-3">
                    <div class="search-wrap" style="margin-top: -15px">
                        <div class="search-icon"></div><!-- //mobile search button -->
                        <form action="{{url('search')}}" id="searchform" class="search-form" method="post" role="search">
                            {{csrf_field()}}
                            <input type="text" id="s" placeholder="Search" class="search-field" name="search">
                            <input type="submit" value="&#xf002;" id="searchsubmit" class="search-submit">
                            <a class="search-close" href="#"><i class="fa fa-times-circle"></i></a>
                        </form>
                    </div><!-- /.search-wrap -->
                </div><!-- /.col-md-3 -->
            </div><!-- /.row -->
         </div><!-- /.container -->
        </div><!-- /.header-wrap -->
    </header>

    @yield('content')

    <!-- Footer -->
    <footer id="footer">
        <div class="footer-widgets">
            <div class="container">
                <div class="row">
                    <div class="col-md-4 gn-animation" data-animation="fadeInUp" data-animation-delay="0" data-animation-offset="75%">
                        <div class="widget widget-brand">
                            <div class="logo logo-footer">
                                <a href="#"><img style="background-color: red" width="200px" src="{{ url('/images/logo-eng.png') }}" alt="Baseerat Afroz" /></a>
                            </div>
                            <p>Example text</p>
                        </div><!-- /.widget-brand -->
                    </div><!-- /.col-md-4 -->
                    <div class="col-md-4 gn-animation" data-animation="fadeInUp" data-animation-delay="0.2s" data-animation-offset="75%">
                        <div class="widget widget-social">
                            <h5 class="widget-title">Follow Us</h5>
                            <div class="social-list">
                                <a href="#"><img src="{{ url('images/facebook.svg') }}" alt="image"></a>
                                <a href="#"><img src="{{ url('images/twitter.svg') }}" alt="image"></a>
                                <a href="#"><img src="{{ url('images/youtube.svg') }}" alt="image"></a>
                                <a href="#"><img src="{{ url('images/dribbble.svg') }}" alt="image"></a>
                            </div>
                        </div><!-- /.widget-social -->
                    </div><!-- /.col-md-4 -->
                    <div class="col-md-2 gn-animation" data-animation="fadeInUp" data-animation-delay="0.4s" data-animation-offset="75%">
                        <div class="widget widget-list">
                            <h5 class="widget-title">Main</h5>
                            <ul class="links-list">
                                <li><a href="#">Mustreads</a></li>
                                <li><a href="#">Tech</a></li>
                            </ul>
                        </div><!-- /.widget-list -->
                    </div><!-- /.col-md-2 -->
                    <div class="col-md-2 gn-animation" data-animation="fadeInUp" data-animation-delay="0.6s" data-animation-offset="75%">
                        <div class="widget widget-list">
                            <h5 class="widget-title">About Us</h5>
                            <ul class="links-list">
                                <li><a href="{{url('about')}}">About Us</a></li>
                                <li><a href="{{url('about')}}">Contact Us</a></li>
                            </ul>
                        </div><!-- /.widget-list -->
                    </div><!-- /.col-md-2 -->
                </div><!-- /.row -->
            </div><!-- /.container -->
        </div><!-- /.footer-widgets -->
        <div class="footer-copyright">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        &copy; 2017 Baseerat Afroz
                        <span style="float: right">Designed by <strong><a target="_blank" href="http://www.quantumbridgeltd.com">Quantum Bridge</a></strong></span>
                    </div><!-- /.col-md-12 -->
                </div><!-- /.row -->
            </div><!-- /.container -->
        </div>
    </footer>

    <!-- Go Top -->
    <a class="go-top">
        <i class="fa fa-chevron-up"></i>
    </a>

    <!-- Javascript -->
    <script type="text/javascript" src="{{ url('/javascript/jquery.min.js') }}"></script>
    <script type="text/javascript" src="{{ url('javascript/vticker.js') }}"></script>
    <script type="text/javascript" src="{{ url('/javascript/bootstrap.min.js') }}"></script>
    <script type="text/javascript" src="{{ url('/javascript/jquery.easing.js') }}"></script>
    <script type="text/javascript" src="{{ url('/javascript/matchMedia.js') }}"></script>
    <script type="text/javascript" src="{{ url('/javascript/jquery-waypoints.js') }}"></script>
    <script type="text/javascript" src="{{ url('javascript/jquery.flexslider.js') }}"></script>
    <script type="text/javascript" src="{{ url('javascript/jquery.transit.js') }}"></script>
    <script type="text/javascript" src="{{ url('javascript/jquery.leanModal.min.js') }}"></script>
    <!-- <script type="text/javascript" src="javascript/jquery.tweet.min.js"></script> -->
    <script type="text/javascript" src="{{ url('javascript/jquery.cookie.js') }}"></script>
    
    <script type="text/javascript" src="{{ url('javascript/jquery.doubletaptogo.js') }}"></script>
    <script type="text/javascript" src="{{ url('javascript/smoothscroll.js') }}"></script>

    <script type="text/javascript" src="{{ url('javascript/main.js') }}"></script>


    <script>
        var layout = {};
        layout.setDirection = function (direction) {
            layout.rtl = (direction === 'rtl');
            document.getElementsByTagName("html")[0].style.direction = direction;
            var styleSheets = document.styleSheets;
            var modifyRule = function (rule) {
                if (rule.style.getPropertyValue(layout.rtl ? 'left' : 'right') && rule.selectorText.match(/\.col-(xs|sm|md|lg)-push-\d\d*/)) {
                    rule.style.setProperty((layout.rtl ? 'right' : 'left'), rule.style.getPropertyValue((layout.rtl ? 'left' : 'right')));
                    rule.style.removeProperty((layout.rtl ? 'left' : 'right'));
                }
                if (rule.style.getPropertyValue(layout.rtl ? 'right' : 'left') && rule.selectorText.match(/\.col-(xs|sm|md|lg)-pull-\d\d*/)) {
                    rule.style.setProperty((layout.rtl ? 'left' : 'right'), rule.style.getPropertyValue((layout.rtl ? 'right' : 'left')));
                    rule.style.removeProperty((layout.rtl ? 'right' : 'left'));
                }
                if (rule.style.getPropertyValue(layout.rtl ? 'margin-left' : 'margin-right') && rule.selectorText.match(/\.col-(xs|sm|md|lg)-offset-\d\d*/)) {
                    rule.style.setProperty((layout.rtl ? 'margin-right' : 'margin-left'), rule.style.getPropertyValue((layout.rtl ? 'margin-left' : 'margin-right')));
                    rule.style.removeProperty((layout.rtl ? 'margin-left' : 'margin-right'));
                }
                if (rule.style.getPropertyValue('float') && rule.selectorText.match(/\.col-(xs|sm|md|lg)-\d\d*/)) {
                    rule.style.setProperty('float', (layout.rtl ? 'right' : 'left'));
                }
            };
            try {
                for (var i = 0; i < styleSheets.length; i++) {
                    var rules = styleSheets[i].cssRules || styleSheets[i].rules;
                    if (rules) {
                        for (var j = 0; j < rules.length; j++) {
                            if (rules[j].type === 4) {
                                var mediaRules = rules[j].cssRules || rules[j].rules
                                for (var y = 0; y < mediaRules.length; y++) {
                                    modifyRule(mediaRules[y]);
                                }
                            }
                            if (rules[j].type === 1) {
                                modifyRule(rules[j]);
                            }

                        }
                    }
                }
            } catch (e) {
                // Firefox might throw a SecurityError exception but it will work
                if (e.name !== 'SecurityError') {
                    throw e;
                }
            }
        }

        layout.setDirection('ltr');
    </script>

    @yield('js')
</body>
</html>
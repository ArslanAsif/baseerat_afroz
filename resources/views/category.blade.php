@extends('layouts.app')

@section('content')
    <!-- Main -->
    <section id="main" class="category-page">
        <div class="container">
            <div class="row">
                @if(isset($search))
                    <div class="col-sm-12" style="margin-top: -70px;">
                        <h3 style='text-align: center; padding: 10px; margin-bottom: 10px; border: 1px solid black;'>{{'Search result for "'.$search.'"'}}</h3>
                    </div>
                @elseif(isset($user))
                    <div class="col-sm-12" style='background-image: url("{{url('/images/author_banner.jpg')}}"); background-position: center; background-size: cover;'>
                        <div style="text-align: center; padding: 10px">
                            <img src="{{url('images/users/'.$user->avatar)}}" style="border: 1px solid white; border-radius: 100%; width: 120px"; height="auto">
                            <h3 style="color: white; margin-top: 0px; margin-bottom: 0px">{{$user->name}}</h3>
                            <p class="col-md-4 col-md-offset-4" style="color: white;">{{$user->editor_descr}}</p>
                        </div>
                    </div>
                    <div class="col-sm-12" style="margin-top: -20px;">
                        <h3 style='text-align: center; padding: 10px; margin-bottom: 10px; border: 1px solid black;'>{{'Articles by "'.$user->name.'"'}}</h3>
                    </div>
                @elseif(isset($title))
                    <div class="col-sm-12" style="margin-top: -70px">
                        <h3 style='text-align: center; padding: 10px; margin-bottom: 10px; border: 1px solid black;'>{{$title}}</h3>
                    </div>
                @else
                    <div class="col-sm-12" style="margin-top: -70px">
                        <h3 style='text-align: center; padding: 10px; margin-bottom: 10px; border: 1px solid black;'>{{$category->title_eng}}</h3>
                    </div>
                @endif

                <div class="{{isset($search) ? 'col-md-12' : 'col-md-8'}}">
                    <?php
                        $count = 0;
                        $limit = $articles->count();
                    ?>
                    @foreach($articles as $article)
                        @if($count % 2 == 0)
                            <div class="row">
                        @endif
                        <div class="{{isset($search) ? 'col-md-4' : 'col-md-6'}}">
                            <div class="post-wrap">
                                <article class="post" dir="auto">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <a><img src="{{url('images/articles/'.$article->picture)}}" alt="img"></a>
                                        </div>
                                        <div class="col-md-12">
                                            <h3 style="padding-top: 10px; padding-bottom: 5px"><a>{{$article->title}}</a></h3>
                                            <div class="cat">
                                                <a>{{\Carbon\Carbon::parse($article->publish_date)->format('M d, Y')}}</a>
                                            </div>
                                            <p class="excerpt-entry">{{$article->summary}}</p>
                                            <div class="activity">
                                                <span class="views"> <a href="{{url('/article/'.$article->id)}}">Read More</a></span>
                                            </div>
                                        </div>
                                    </div>
                                </article><!--  /.post -->
                            </div><!-- /.social-media-posts -->
                        </div>
                        <?php $count++; ?>
                        @if($count % 2 == 0 || $count == $limit)
                            </div>
                        @endif
                    @endforeach
                    <div class="col-md-12">
                            {{ $articles->links() }}
                    </div>

                </div><!-- /.col-md-8 -->

                @if(isset($category) || isset($title) || isset($user))
                <div class="col-md-4">
                    <div class="sidebar-widget-1">
                        <div class="widget widget-recent" data-animation="fadeInUp" data-animation-delay="0" data-animation-offset="75%">
                            <h5 class="widget-title">Popular</h5>
                            <ul>
                                @foreach($popular_articles as $article)
                                    <li>
                                        <div class="thumb">
                                            <a href="{{url('article/'.$article->id)}}"><img src="{{ url('images/articles/'.$article->picture) }}" alt="img"></a>
                                        </div>
                                            @if(preg_match("/[ط|ص|ھ|د|ٹ|پ|ت|ب|ج|ح|م|و|ر|ن|ل|ہ|ا|ک|ی|ق|ف|ے|س|ش|غ|ع]+/", $article->title))
                                            <div class="content" style="text-align: right">
                                            @else
                                            <div class="content">
                                            @endif
                                                <h3><a href="{{url('article/'.$article->id)}}">{{$article->title}}</a></h3>
                                                <div class="date">{{\Carbon\Carbon::parse($article->publish_date)->format('M d, Y')}}</div>
                                            </div>

                                    </li>
                                @endforeach
                            </ul>
                        </div><!-- /.widget-recent -->

                        <div class="widget widget-follow-us gn-animation" data-animation="fadeInUp" data-animation-delay="0" data-animation-offset="75%">
                            <h5 class="widget-title text-dark">Follow Us</h5>
                            <div class="socials">
                                <a class="facebook" href="#"><i class="fa fa-facebook"></i></a>
                                <a class="twitter" href="#"><i class="fa fa-twitter"></i></a>
                                <a class="google" href="#"><i class="fa fa-google-plus"></i></a>
                                <a class="youtube" href="#"><i class="fa fa-youtube"></i></a>
                                <a class="linkedin" href="#"><i class="fa fa-linkedin"></i></a>
                                <a class="tumblr" href="#"><i class="fa fa-tumblr"></i></a>
                            </div>
                        </div><!-- /.widget-follow-us -->
                        <div class="widget widget-categories gn-animation" data-animation="fadeInUp" data-animation-delay="0" data-animation-offset="75%">
                            <h5 class="widget-title">Archives</h5>
                            <ul class="cat-list">
                                @foreach ($archive_by_date as $date => $posts)
                                    <li><a href="{{url('/archive/'.$date)}}">{{ $date }} <span>({{$posts->count()}})</span></a></li>
                                @endforeach
                                {{--<li><a href="#">December 2013 <span>(0)</span></a></li>--}}
                            </ul>
                        </div><!-- /.widget-categories -->
                        <div class="widget widget-subscribe gn-animation" data-animation="fadeInUp" data-animation-delay="0" data-animation-offset="75%">
                            <h5 class="widget-title">Baseerat-Afroz Newsetter</h5>
                            <p>Subscribe to our email newsletter for updates.</p>
                            <form method="post" action="{{url('newsletter/subscribe')}}" id="subscribe-form">
                                {{csrf_field()}}
                                <div id="subscribe-content">
                                    <div class="input">
                                        <input type="email" id="subscribe-email" name="subscribe-email" placeholder="Email">
                                    </div>
                                    <div class="button">
                                        <button type="submit" id="subscribe-button" class="" title="Subscribe now">Subscribe</button>
                                    </div>
                                </div>
                                <div id="subscribe-msg"></div>
                            </form>
                        </div><!-- /.widget-subscribe -->
                    </div><!-- /.sidebar -->
                </div><!-- /.col-md-4 -->
                @endif
            </div><!-- /.row -->
        </div><!-- /.container -->
    </section>
@endsection
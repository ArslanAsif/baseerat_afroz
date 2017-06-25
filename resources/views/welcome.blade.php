@extends('layouts.app')

@section('content')
<!-- Main -->
<section id="main" class="rtl">
    <div class="container">
        <div class="row">
            <div class="col-md-8">
                <div class="featured-posts gn-animation" data-animation="fadeInUp" data-animation-delay="0" data-animation-offset="75%">
                    <div class="content-left">
                        @if(isset($spotlights[0]))
                        <article class="post" dir="auto">
                            <p hidden>{{$spotlights[0]->article->title}}</p>
                            <div class="thumb">
                                <a href="{{url('article/'.$spotlights[0]->article_id)}}"><img src="{{url('images/articles/'.$spotlights[0]->article->picture)}}" alt="img"></a>
                            </div>
                            <div class="cat">
                                <a href="{{url('category/'.$spotlights[0]->article->category_id)}}">{{$spotlights[0]->article->category->title_eng}}</a>
                            </div>
                            <h5 style="font-size: 20px; font-weight: bold; margin-top: 0px"><a href="{{url('article/'.$spotlights[0]->article_id)}}">{{$spotlights[0]->article->title}}</a></h5>
                            <p class="excerpt-entry">{{$spotlights[0]->article->summary}}</p>
                            <div class="post-meta">
                                <span class="author">By <a href="{{url('user/'.$spotlights[0]->article->user_id)}}">{{$spotlights[0]->article->user->name}}</a></span>
                                {{--<div class="activity">--}}
                                    {{--<span class="views">345</span><span class="comment"><a href="#">15</a></span>--}}
                                {{--</div>--}}
                            </div>
                        </article><!--  /.post -->
                        @endif
                    </div><!-- /.content-left -->
                    <div class="content-right">
                        <?php $first = 1;?>
                        @foreach($spotlights as $spotlight)
                        @if($first++ != 1)
                        <article class="post" dir="auto">
                            <p hidden>{{$spotlight->article->title}}</p>
                            <div class="thumb">
                                <a href="{{url('article/'.$spotlight->article_id)}}"><img src="{{url('images/articles/'.$spotlight->article->picture)}}" alt="img"></a>
                            </div>
                            <div class="cat">
                                <a href="{{url('category/'.$spotlight->article->category_id)}}">{{$spotlight->article->category->title_eng}}</a>
                            </div>
                            <h3><a href="{{url('article/'.$spotlight->article_id)}}">{{$spotlight->article->title}}</a></h3>

                            {{--<div class="activity">--}}
                                {{--<span class="views">12</span><span class="comment"><a href="#">15</a></span>--}}
                            {{--</div>--}}
                        </article><!--  /.post -->
                        @endif
                        @endforeach
                    </div><!-- /.content-right -->
                </div><!-- /.featured-posts -->
                <div class="highlights-posts gn-animation" data-animation="fadeInUp" data-animation-delay="0" data-animation-offset="75%">
                    <div class="gn-line"></div>
                    <div class="section-title">
                        <h4><a href="#">Highlights</a></h4>
                    </div>
                    <?php $x = 1 ?>
                    @foreach($highlights as $highlight)
                    @if($x % 2 == 0)
                        <article class="post last" dir="auto">
                    @else
                        <article class="post" dir="auto">
                    @endif
                            <p hidden>{{ $highlight->article->title }}</p>
                            <div class="thumb">
                                <a href="{{url('article/'.$highlight->article_id)}}"><img src="{{url('images/articles/'.$highlight->article->picture)}}" alt="img"></a>
                            </div>
                            <div class="cat">
                                <a href="{{url('/category/'.$highlight->article->category_id)}}">{{ $highlight->article->category->title_eng}}</a>
                            </div>
                            <h3><a href="{{url('article/'.$highlight->article_id)}}">{{ $highlight->article->title }}</a></h3>
                            {{--<div class="activity">--}}
                                {{--<span class="views">12</span><span class="comment"><a href="#">0</a></span>--}}
                            {{--</div>--}}
                        </article><!--  /.post -->
                        <?php $x++;?>
                    @endforeach
                </div><!-- /.highlights-posts -->


            </div><!-- /.col-md-8 -->
            <div class="col-md-4">
                <div class="sidebar-widget-1">
                    <div class="widget widget-recent gn-animation" data-animation="fadeInUp" data-animation-delay="0" data-animation-offset="75%">
                        <h5 class="widget-title">Recent Posts</h5>
                        <ul>
                            @foreach($recent_articles as $article)
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

                    <div class="widget widget-most-popular gn-animation" data-animation="fadeInUp" data-animation-delay="0" data-animation-offset="75%">
                        <h5 class="widget-title">5 Most Popular</h5>
                        <ul>
                            <?php $i=0 ?>
                            @foreach($popular_articles as $article)
                            @if(preg_match("/[ط|ص|ھ|د|ٹ|پ|ت|ب|ج|ح|م|و|ر|ن|ل|ہ|ا|ک|ی|ق|ف|ے|س|ش|غ|ع]+/", $article->title))
                                <li style="text-align: right">
                            @else
                                <li>
                            @endif
                                <div class="order">{{++$i}}</div>
                                <p><a href="{{url('article/'.$article->id)}}">{{$article->title}}</a></p>
                            </li>
                            @endforeach
                        </ul>
                    </div><!-- /.widget-popular -->

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
                                <li><a href="{{url('archive/'.$date)}}">{{ $date }} <span>({{$posts->count()}})</span></a></li>
                            @endforeach
                            {{--<li><a href="#">December 2013 <span>(0)</span></a></li>--}}
                        </ul>
                    </div><!-- /.widget-categories -->
                    <div class="widget widget-subscribe gn-animation" data-animation="fadeInUp" data-animation-delay="0" data-animation-offset="75%">
                        <h5 class="widget-title">Good News Newsetter</h5>
                        <p>Subscribe to our email newsletter for good news, sent out every Monday.</p>
                        <form method="post" action="#" id="subscribe-form" data-mailchimp="true">
                            <div id="subscribe-content">
                                <div class="input">
                                   <input type="text" id="subscribe-email" name="subscribe-email" placeholder="Email">
                                </div>
                                <div class="button">
                                   <button type="button" id="subscribe-button" class="" title="Subscribe now">Subscribe</button>
                                </div>
                            </div>
                            <div id="subscribe-msg"></div>
                        </form>
                    </div><!-- /.widget-subscribe -->
                </div><!-- /.sidebar -->
            </div><!-- /.col-md-4 -->

            </div><!-- /.col-md-12 -->
            <div class="col-md-12">
                <div class="editors-posts gn-animation" data-animation="fadeInUp" data-animation-delay="0" data-animation-offset="75%">
                    <div class="gn-line"></div>
                    <div class="section-title">
                        <h4><a href="#">Editors Picks</a></h4>
                    </div>
                    <div class="post-wrap">
                        @foreach($editorpicks as $editorpick)
                        <article class="post" dir="auto">
                            <p hidden>{{$editorpick->article->title}}</p>
                            <div class="thumb">
                                <a href="{{url('article/'.$editorpick->article_id)}}"><img src="{{url('images/articles/'.$editorpick->article->picture)}}" alt="img"></a>
                            </div>
                            <div class="content">
                                <div class="cat">
                                    <a href="{{url('category/'.$editorpick->article->category_id)}}">{{$editorpick->article->category->title_eng}}</a>
                                </div>
                                <h3><a href="{{url('article/'.$editorpick->article_id)}}">{{$editorpick->article->title}}</a></h3>
                                <p class="excerpt-entry">{{$editorpick->article->summary}}</p>
                                <div class="post-meta">
                                    <span class="author">By <a href="{{url('user/'.$editorpick->article->user_id)}}">{{$editorpick->article->user->name }}</a></span>
                                    <span class="time"> -  {{ \Carbon\Carbon::parse($editorpick->created_at)->diffInDays(\Carbon\Carbon::now()) }} days ago</span>
                                </div>
                            </div>
                        </article><!--  /.post -->
                        @endforeach
                    </div><!-- /.post-wrap -->
                </div><!-- /.editors-posts -->

                <div class="popular-posts gn-animation" data-animation="fadeInUp" data-animation-delay="0" data-animation-offset="75%">
                    <div class="gn-line"></div>
                    <div class="section-title">
                        <h4><a href="#">Popular Posts</a></h4>
                    </div>
                    <div class="content-left">
                        @if(isset($popular_articles[0]))
                        <article class="post" dir="auto">
                            <p hidden>{{$popular_articles[0]->title}}</p>
                            <div class="thumb">
                                <a href="{{url('article/'.$popular_articles[0]->id)}}"><img src="{{url('images/articles/'.$popular_articles[0]->picture)}}" alt="img"></a>
                            </div>
                            <div class="cat">
                                <a href="{{url('category/'.$popular_articles[0]->category_id)}}">{{$popular_articles[0]->category->title_eng}}</a>
                            </div>
                            <h3><a href="{{url('article/'.$popular_articles[0]->id)}}">{{$popular_articles[0]->title}}</a></h3>
                            <p class="excerpt-entry">{{$popular_articles[0]->sumary}}</p>
                            <div class="post-meta">
                                <span class="author">By <a href="{{url('user/'.$popular_articles[0]->user_id)}}">{{$popular_articles[0]->user->name}}</a></span>
                                {{--<div class="activity">--}}
                                    {{--<span class="views">345</span><span class="comment"><a href="#">15</a></span>--}}
                                {{--</div>--}}
                            </div>
                        </article><!--  /.post -->
                        @endif
                    </div><!-- /.content-left -->
                    <div class="content-right">
                        <?php $first_popular = 1; ?>
                        @foreach($popular_articles as $article)
                        @if($first_popular++ != 1)
                        <article class="post" dir="auto">
                            <p hidden>{{$article->title}}</p>
                            <div class="thumb">
                                <a href="{{url('article/'.$article->id)}}"><img src="{{url('images/articles/'.$article->picture)}}" alt="img"></a>
                            </div>
                            <div class="content">
                                <h3><a href="{{url('article/'.$article->id)}}">{{$article->title}}</a></h3>
                                <span class="date">{{$article->publish_date}}</span>
                            </div>
                        </article><!--  /.post -->
                        @endif
                        @endforeach
                    </div><!-- /.content-right -->
                </div><!-- /.popular-posts -->

                <div class="trending-posts">
                    <div class="gn-line"></div>

                    <?php
                        $cat_count = 1;
                        $animation_delay = 0;
                    ?>
                    @foreach($hp_categories as $category)
                    @if(isset($category->category->id))
                        <div class="{{ ($cat_count++ == 4) ? 'one-fourth last gn-animation' : 'one-fourth gn-animation' }}" data-animation="fadeInUp" data-animation-delay="{{'0.'.$animation_delay++}}" data-animation-offset="75%">
                            <div class="section-title">
                                <h4><a href="{{url('category/'.$category->category->id)}}">{{$category->category->title_eng}} ({{$category->category->articles->count()}})</a></h4>
                            </div>

                            <?php $cat_first = 0;?>
                            @foreach($category->category->articles as $article)
                            <article class="{{ ($cat_first == 0) ? 'post first':'post' }}" dir="auto">
                                <p hidden>{{$article->title}}</p>
                                @if($cat_first == 0)
                                <div class="thumb">
                                    <a href="{{url('article'.$article->id)}}"><img src="{{ url('images/articles/'.$article->picture) }}" alt="img"></a>
                                </div>
                                @endif
                                <span class="date">{{\Carbon\Carbon::parse($article->publish_date)->format('M d, Y')}}</span>
                                <h3><a href="{{url('article'.$article->id)}}">{{$article->title}}</a></h3>
                            </article><!--  /.post -->
                            <?php $cat_first++;?>
                            @endforeach
                        </div>
                    @endif
                    @endforeach
                </div><!-- /.trending-posts -->
                <div class="gn-line"></div>
            </div><!-- /.col-md-12 -->

        </div><!-- /.row -->
    </div><!-- /.container -->
</section>
@endsection
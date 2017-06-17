@extends('layouts.app')

@section('content')
    <!-- Main -->
    <section id="main" class="article-endless">
        <div class="container">
            <div class="row">
                <div class="col-md-4">
                    <div id="sidebar2">
                        <div class="tabs style2">
                            <ul class="menu-tab">
                                <li class="active"><a href="#">Popular</a></li>
                                <li><a href="#">Latest</a></li>
                            </ul><!-- /.menu-tab -->
                            <div class="content-tab scroll">
                                <div class="content">
                                    <ul class="content-list">
                                        @foreach($popular_articles as $article)
                                            <li><a href="{{url('article/'.$article->id)}}">{{$article->title}}</a></li>
                                        @endforeach
                                    </ul>
                                </div><!-- /.content-list -->
                                <div class="content">
                                    <ul class="content-list">
                                        @foreach($recent_articles as $article)
                                            <li><a href="{{url('article/'.$article->id)}}">{{$article->title}}</a></li>
                                        @endforeach
                                    </ul>
                                </div><!-- /.comments -->
                            </div><!-- /.content-tab -->
                        </div><!-- /.tabs -->
                        <div class="toggle-panel" style="display: none"></div>
                    </div><!-- /#sidebar2 -->
                </div><!-- /.col-md-4 -->
                <div class="col-md-8">
                    <div class="post-wrap posts posts-list">
                        <article class="post">
                            <div class="head-post">
                                <h2><a href="#">{{$this_article->title}}</a></h2>
                                <p>{{$this_article->summary}}</p>
                                <div class="meta">
                                    <span class="author">By <a href="#">{{$this_article->user->name}}</a></span>
                                    <span class="time"> Published on {{\Carbon\Carbon::parse($this_article->publish_date)->format('M d, Y')}}</span>
                                </div>
                            </div><!-- /.head-post -->
                            <div class="body-post">
                                <div class="main-post">
                                    <div class="entry-post">
                                        <img width="100%" src="{{url('images/articles/'.$this_article->picture)}}">
                                        <?php echo $this_article->description; ?>

                                    </div><!-- /.entry-post -->
                                    {{--<div class="tags">--}}
                                        {{--<h4>In this article:</h4>--}}
                                        {{--<a href="#">Startups</a>--}}
                                        {{--<a href="#">Technology</a>--}}
                                        {{--<a href="#">Millions of dollars</a>--}}
                                        {{--<a href="#">Paul Graham</a>--}}
                                    {{--</div>--}}
                                    {{--<div class="load-comment">--}}
                                        {{--<a href="#">Load Comments (35)</a>--}}
                                    {{--</div>--}}
                                </div><!-- /.main-post -->
                            </div><!-- /.body-post -->
                        </article><!-- /.post -->

                        <div class="fb-like" data-href="{{'http://rahimia.dev/article/'.$this_article->id}}" data-layout="standard" data-action="like" data-size="large" data-show-faces="true" data-share="true"></div>

                        <div data-width="100%" class="fb-comments" data-href="{{'http://rahimia.dev/article/'.$this_article->id}}" data-numposts="5"></div>

                        {{--<div class="loadding">--}}
                            {{--<span class="infinite"></span>--}}
                        {{--</div>--}}
                    </div><!-- /.post-wrap -->
                </div><!-- /.col-md-8 -->
            </div><!-- /.row -->
        </div><!-- /.container -->
    </section>
@endsection
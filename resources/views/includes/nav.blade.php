<nav id="mainnav" class="mainnav">
    <ul class="menu">
        {{--<li class="has-children"><a class="active" href="index-2.html">Home</a>--}}
            {{--<ul class="sub-menu">--}}
                {{--<li><a href="index-banner.html">Home with Banner</a></li>--}}
                {{--<li><a href="index-custom.html">Home Customize</a></li>--}}
                {{--<li class="has-children"><a href="#">Third Level Item</a>--}}
                    {{--<ul class="sub-menu">--}}
                        {{--<li><a href="#">Sublevel 1</a></li>--}}
                        {{--<li><a href="#">Sublevel 2</a></li>--}}
                        {{--<li><a href="#">Sublevel 3</a></li>--}}
                        {{--<li><a href="#">Sublevel 4</a></li>--}}
                        {{--<li><a href="#">Sublevel 5</a></li>--}}
                    {{--</ul><!-- /.submenu -->--}}
                {{--</li>--}}
            {{--</ul><!-- /.submenu -->--}}
        {{--</li>--}}

        @foreach($categories as $category)
            {{--<li><a href="{{url('category/'.strtolower($category->title_eng))}}">{{$category->title_eng}}</a></li>--}}
            <li><a href="{{url('category/'.$category->id)}}">{{$category->title_eng}}</a></li>
        @endforeach
    </ul><!-- /.menu -->
</nav><!-- /nav -->
<!-- sidebar menu -->
<div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
    <div class="menu_section">
        <ul class="nav side-menu">
            <li>.</li>

            @if(Auth::user()->type == 'admin')
            <li><a href="{{ url('/admin/dashboard/') }}"><i class="fa fa-home"></i> Dashboard</a></li>
            @endif

            @if(Auth::user()->type == 'admin')
            <li><a href="{{ url('/admin/homepage/') }}"><i class="fa fa-cogs"></i> Manage Homepage</a></li>
            @endif

            <li><a><i class="fa fa-edit"></i> Articles <span class="fa fa-chevron-down"></span></a>
                <ul class="nav child_menu">
                    <li><a href="{{ url('/admin/article/add') }}">Add Article</a></li>
                    <li><a href="{{ url('/admin/article/mysubmission') }}">My Submissions</a></li>

                    @if(Auth::user()->type == 'admin' || Auth::user()->type == 'editor')
                    <li><a href="{{ url('/admin/article/headlines') }}">Headlines</a></li>
                    <li><a href="{{ url('/admin/article/usersubmission') }}">User Submissions</a></li>
                    <li><a href="{{ url('/admin/article/unpublished') }}">Unpublished Articles</a></li>
                    <li><a href="{{ url('/admin/article/published') }}">Published Articles</a></li>
                    @endif
                </ul>
            </li>

            @if(Auth::user()->type == 'editor')
            <li><a href="{{ url('/admin/user/') }}"><i class="fa fa-users"></i> Users</a></li>
            @endif

            @if(Auth::user()->type == 'admin')
            <li><a><i class="fa fa-list"></i> Categories <span class="fa fa-chevron-down"></span></a>
                <ul class="nav child_menu">
                    <li><a href="{{ url('/admin/category/add') }}">Add Category</a></li>
                    <li><a href="{{ url('/admin/category/') }}">Manage Categories</a></li>
                </ul>
            </li>

            <li><a><i class="fa fa-users"></i> Users <span class="fa fa-chevron-down"></span></a>
                <ul class="nav child_menu">
                    <li><a href="{{ url('/admin/user/') }}">Manage Users</a></li>
                    <li><a href="{{ url('/admin/subscriber') }}">Subscribers</a></li>
                </ul>
            </li>

            {{--<li><a><i class="fa fa-file"></i> Reports <span class="fa fa-chevron-down"></span></a>--}}
                {{--<ul class="nav child_menu">--}}
                    {{--<li><a href="{{ url('/') }}">Articles Published</a></li>--}}
                    {{--<li><a href="{{ url('/') }}">Registered Users</a></li>--}}
                    {{--<li><a href="{{ url('admin/user/active') }}">Active Users</a></li>--}}
                    {{--<li><a href="{{ url('admin/user/inactive') }}">Inactive Users</a></li>--}}
                {{--</ul>--}}
            {{--</li>--}}

            <li><a><i class="fa fa-address-card"></i> About <span class="fa fa-chevron-down"></span></a>
                <ul class="nav child_menu">
                    <li><a href="{{ url('admin/about/aboutus') }}">About Us</a></li>
                    <li><a href="{{ url('admin/about/contact') }}">Contact Info</a></li>
                    <li><a href="{{ url('admin/about/terms') }}">Terms and Conditions</a></li>
                </ul>
            </li>

            <li><a href="{{ url('/admin/article/trash') }}"><i class="fa fa-trash"></i> Trash</a></li>
            @endif
        </ul>
    </div>

</div>
<!-- /sidebar menu -->
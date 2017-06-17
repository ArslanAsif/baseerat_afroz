@extends('admin.layouts.admin_panel')

@section('content')
    <div class="right_col" role="main">
        <div class="">
            <div class="clearfix"></div>

            <div class="row">
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <div class="x_panel">
                        <div class="x_title">
                            <h2>
                                @if(isset($type))
                                     Unpublished Articles
                                @else
                                    My Submissions
                                @endif
                            </h2>
                            <ul class="nav navbar-right panel_toolbox">
                                <li class="pull-right"><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                            </ul>
                            <div class="clearfix"></div>
                        </div>
                        <div class="x_content">
                            <p class="text-muted font-13 m-b-30">
                            @if(isset($type))
                                Unpublished articles can be reviwed and published from here.
                            @else
                                User submitted news, articles and colums can be reviewed here for publishing. Once Published it will be moved to published articles.
                            @endif
                                
                            </p>

                            <div class="table-responsive">
                                <table id="datatable" class="table table-bordered">
                                    <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Title</th>
                                        <th>Category</th>
                                        <th>Submitted On</th>
                                        <th>Published On</th>
                                        <th></th>
                                    </tr>
                                    </thead>


                                    <tbody>

                                    @foreach($news as $this_news)
                                    @if(isset($this_news->publish_date))
                                    <tr>
                                    @else
                                    <tr style='background-color: white; color: red; font-weight: bold'>
                                    @endif
                                        <td>{{ $this_news->id }}</td>
                                        <td>{{ $this_news->title }}</td>
                                        <td>{{ $this_news->category->title_eng }}</td>
                                        <td>{{ $this_news->created_at }}</td>
                                        <td>{{ isset($this_news->publish_date) ? $this_news->publish_date : 'Unpublished' }}</td>
                                        <td>
                                        @if(isset($this_news->publish_date))
                                            <a data-toggle="tooltip" title="View" href="{{ url('/article/'.$this_news->id) }}" class="btn btn-primary"><span class="fa fa-eye"></span></a>
                                        @else
                                            <a data-toggle="tooltip" title="View" href="#" onclick="this.preventDefaults()" class="btn btn-primary" disabled><span class="fa fa-eye"></span></a>
                                        @endif
                                        </td>
                                    </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@include('admin.includes.datatable_links')
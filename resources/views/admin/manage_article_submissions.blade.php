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
                                    @if($type == 'trash')
                                        Trash <a href="{{url('/admin/article/deleteall')}}" class="btn btn-sm btn-danger">Delete All</a>
                                    @elseif($type == 'submission')
                                        User Submissions
                                    @else
                                     Unpublished Articles
                                    @endif
                                @else
                                    User Submissions
                                @endif
                            </h2>
                            <ul class="nav navbar-right panel_toolbox">
                                <li class="pull-right"><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                            </ul>
                            <div class="clearfix"></div>
                        </div>
                        <div class="x_content">
                            @if(Session::has('message'))
                                <div class="alert alert-success">
                                    <strong>Success!</strong> {{Session::get('message')}}
                                </div>
                            @endif
                            <p class="text-muted font-13 m-b-30">
                            @if(isset($type))
                                @if($type == 'trash')
                                    Deleted articles can be restored from trash
                                @elseif($type == 'submission')
                                    User submitted articles can be reviwed from here.
                                @else
                                    Unpublished articles can be reviwed and published from here.
                                @endif
                            @else
                                User submitted news, articles and colums can be reviewed here for publishing. Once Published it will be moved to published articles.
                            @endif
                                
                            </p>

                            <div class="table-responsive">
                                <table id="datatable" class="table table-striped table-bordered">
                                    <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Title</th>
                                        <th>Category</th>
                                        <th>Author</th>
                                        <th>Submitted On</th>
                                        <th></th>
                                    </tr>
                                    </thead>


                                    <tbody>

                                    @foreach($news as $this_news)
                                    <tr>
                                        <td>{{ $this_news->id }}</td>
                                        <td>{{ $this_news->title }}</td>
                                        <td>{{ $this_news->category->title_eng }}</td>
                                        <td>{{ $this_news->user->name }}</td>
                                        <td>{{ $this_news->created_at }}</td>
                                        @if(isset($type))
                                            @if($type == 'trash')
                                                <td>
                                                    <a data-toggle="tooltip" title="Edit" href="{{ url('/admin/article/edit/'.$this_news->id) }}" class="btn btn-default"><span class="fa fa-pencil-square-o"></span></a>
                                                    <a data-toggle="tooltip" title="Restore" href="{{ url('/admin/article/recycle/'.$this_news->id) }}" class="btn btn-danger"><span class="fa fa-recycle"></span></a>
                                                </td>
                                            @else
                                                <td>
                                                    <a data-toggle="tooltip" title="Publish" href="#" class="btn btn-success" onclick="event.preventDefault();
                                                            document.getElementById('{{ "publish-form".$this_news->id }}').submit();"><span class="fa fa-check"></span></a>

                                                    <form id="{{ 'publish-form'.$this_news->id }}" action="{{ isset($type) ? url('/admin/article/publish/'.$this_news->id) : url('/admin/article/approve/'.$this_news->id) }}" method="POST" style="display: none;">
                                                        {{ csrf_field() }}
                                                    </form>

                                                    <a data-toggle="tooltip" title="Edit" href="{{ url('/admin/article/edit/'.$this_news->id) }}" class="btn btn-default"><span class="fa fa-pencil-square-o"></span></a>
                                                    <a data-toggle="tooltip" title="Delete" href="{{ url('/admin/article/delete/'.$this_news->id) }}" class="btn btn-danger"><span class="fa fa-trash-o"></span></a>
                                                </td>
                                            @endif
                                        @endif
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
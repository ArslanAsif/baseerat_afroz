@extends('admin.layouts.admin_panel')

@section('content')
    <div class="right_col" role="main">
        <div class="">
            <div class="clearfix"></div>

            <div class="row">
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <div class="x_panel">
                        <div class="x_title">
                            <h2>Published Articles <small></small></h2>
                            <ul class="nav navbar-right panel_toolbox">
                                <li class="pull-right"><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                            </ul>
                            <div class="clearfix"></div>
                        </div>
                        <div class="x_content">
                            <p class="text-muted font-13 m-b-30">
                                Published news, articles, columns are managed here. If unpublished, it will move back to unpublished articles.
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
                                        <th>Published On</th>
                                        <th></th>
                                    </tr>
                                    </thead>


                                    <tbody>

                                    @foreach($news as $this_news)
                                        <tr>
                                            <td>{{ $this_news->id }}</td>
                                            <td>{{ $this_news->title }}</td>
                                            <td>{{ $this_news->category->title_eng}}</td>
                                            <td>{{ $this_news->user->name }}</td>
                                            <td>{{ $this_news->created_at }}</td>
                                            <td>{{ $this_news->publish_date }}</td>
                                            <td>
                                                <a data-toggle="tooltip" title="Unpublish" href="#" class="btn btn-warning" onclick="event.preventDefault();
                                                                         document.getElementById('{{ "publish-form".$this_news->id }}').submit();"><span class="fa fa-close"></span></a>

                                                <form id="{{ 'publish-form'.$this_news->id }}" action="{{ url('/admin/article/unpublish/'.$this_news->id) }}" method="POST" style="display: none;">
                                                    {{ csrf_field() }}
                                                </form>

                                                <a data-toggle="tooltip" title="Send as Newsletter" href="{{ url('/article/newsletter/'.$this_news->id) }}" class="btn btn-primary"><span class="fa fa-plane"></span></a>

                                                <a data-toggle="tooltip" title="Edit!" href="{{ url('/admin/article/edit/'.$this_news->id) }}" class="btn btn-default"><span class="fa fa-pencil-square-o"></span></a>

                                                <a data-toggle="tooltip" title="Delete" href="{{ url('/admin/article/delete/'.$this_news->id) }}" class="btn btn-danger"><span class="fa fa-trash-o"></span></a>

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
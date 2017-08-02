@extends('admin.layouts.admin_panel')

@section('content')
    <div class="right_col" role="main">
        <div class="">
            <div class="clearfix"></div>

            <div class="row">
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <div class="page-title">
                        <div class="title_left">
                            <h3>Headlines</h3>
                            <p class="text-muted font-13 m-b-30">
                                Headlines can be added or removed here.
                            </p>
                        </div>

                        <div class="row">
                            <div class="col-sm-12">
                                @include('admin.includes.errors')
                                @if(Session::has('message'))
                                    <div class="alert alert-success">
                                        <strong>Success!</strong> {{Session::get('message')}}
                                    </div>
                                @endif

                            </div>
                        </div>
                    </div>

                    <div class="x_panel">
                        <div class="x_title">
                            <h2>Add Headline</h2>

                            <ul class="nav navbar-right panel_toolbox">
                                <li class="pull-right"><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                            </ul>
                            <div class="clearfix"></div>
                        </div>
                        <div class="x_content">
                            <div>
                                <form method="post" action="{{url('admin/article/headlines/add')}}">
                                    {{csrf_field()}}
                                    <select class="form-control" name="id">
                                        <option></option>
                                        @foreach($all as $title)
                                            <option value="{{$title->id}}">{{$title->title}}</option>
                                        @endforeach
                                    </select>
                                    <br>
                                    <button type="submit" class="btn btn-primary"><span class="fa fa-plus"></span> Add</button>
                                </form>
                            </div>
                        </div>
                    </div>


                    <div class="x_panel">
                        <div class="x_title">
                            <h2>
                                Manage Headlines
                            </h2>
                            <ul class="nav navbar-right panel_toolbox">
                                <li class="pull-right"><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                            </ul>
                            <div class="clearfix"></div>
                        </div>
                        <div class="x_content">
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
                                            <td>
                                                <a data-toggle="tooltip" title="Remove from headlines" href="{{ url('/admin/article/headlines/remove/'.$this_news->id) }}" class="btn btn-danger"><span class="fa fa-trash"></span></a>
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
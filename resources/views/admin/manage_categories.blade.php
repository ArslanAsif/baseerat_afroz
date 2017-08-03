@extends('admin.layouts.admin_panel')

@section('content')
    <div class="right_col" role="main">
        <div class="">
            <div class="clearfix"></div>

            <div class="row">
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <div class="x_panel">
                        <div class="x_title">
                            <h2>Manage Categories <small></small></h2>
                            <ul class="nav navbar-right panel_toolbox">
                                <li class="pull-right"><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                            </ul>
                            <div class="clearfix"></div>
                        </div>
                        <div class="x_content">
                            <p class="text-muted font-13 m-b-30">
                            </p>
                            <div class="table-responsive">
                                <table id="datatable" class="table table-striped table-bordered">
                                    <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Priority</th>
                                        {{--<th>Parent</th>--}}
                                        <th>Status</th>
                                        <th>Added On</th>
                                        <th></th>
                                    </tr>
                                    </thead>

                                    <tbody>

                                    @foreach($categories as $category)
                                    <tr>
                                        <td>{{ $category->title_eng."-".$category->title_ur }}</td>
                                        <td>{{ $category->priority }}</td>
                                        {{--<td>{{ isset($category->parent->id) ? $category->parent->title_eng : '' }}</td>--}}
                                        <td>{{ $category->active ? 'Active' : 'Inactive' }}</td>
                                        <td>{{ $category->created_at }}</td>
                                        <td>
                                            <a href="{{ url('/admin/category/edit/'.$category->id) }}" class="btn btn-default"><span class="fa fa-pencil-square-o"></span></a>
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
@extends('admin.layouts.admin_panel')

@section('content')
    <div class="right_col" role="main">
        <div class="">
            <div class="clearfix"></div>

            <div class="row">
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <div class="x_panel">
                        <div class="x_title">
                            <h2>Subscriber <small>(Verified)</small></h2><span class="pull-right"><a href="{{ url('admin/newsletter') }}" class="btn btn-lg btn-primary">Edit Newsletter</a><!-- <a href="{{ url('admin/newsletter/send') }}" class="btn btn-lg btn-danger">Send Newsletter</a> --></span>
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
                                        <th>ID</th>
                                        <th>Email</th>
                                        <th></th>
                                    </tr>
                                    </thead>


                                    <tbody>
                                    @foreach($subcribe as $subcribe)
                                        <tr>
                                            <td>{{$subcribe->id}}</td>
                                            <td>{{$subcribe->email}}</td>
                                            <td>
                                                <a href="{{url('admin/deleteSubscriber/'.$subcribe->id)}}" class="btn btn-danger"><span class="fa fa-trash-o"></span></a>
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
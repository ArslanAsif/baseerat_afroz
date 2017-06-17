@extends('admin.layouts.admin_panel')

@section('content')
    <!-- page content -->
    <div class="right_col" role="main">
        <div class="">
            <div class="clearfix"></div>
            <div class="row">
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <div class="page-title">
                        <div class="title_left">
                            <h3>User Profile</h3>
                        </div>
                    </div>

                    <div class="x_panel">
                        <!-- <div class="x_title">
                            <h2></h2>
                            <ul class="nav navbar-right panel_toolbox">
                                <li class="pull-right"><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                            </ul>
                            <div class="clearfix"></div>
                        </div> -->
                        <div class="x_content">

                            <div class="col-sm-12">
                                <div class="row">
                                    <h1 style="text-align: center; margin-top: -5px">
                                        {{ $user->name }}<hr>
                                    </h1>
                                </div>
                            </div>

                            <div class="row" >
                                <div class="col-sm-4 col-xs-12">
                                    <div class="row">
                                        <img width="100%" src="{{ isset($user->avatar) ? url('$user->avatar') : url('/images/user.jpg')}}" alt="User Avatar">
                                    </div>
                                </div>

                                <div class="col-sm-8 col-xs-12">
                                    <div class="row">
                                        <label style="text-align: right;" class="col-md-3 col-sm-4 col-xs-4">
                                            Email :
                                        </label>
                                        <span class="col-md-9 col-sm-8 col-xs-8">
                                            {{ $user->email }}
                                        </span>
                                    </div>

                                    <div class="row">
                                        <div class="form-group">
                                            <label style="text-align: right; {{(\Illuminate\Support\Facades\Auth::user()->type == 'admin') ? 'padding: 10px' : ''}}" class="col-md-3 col-sm-4 col-xs-4" for="user_type">
                                                Type :
                                            </label>
                                            @if(\Illuminate\Support\Facades\Auth::user()->type == 'admin')
                                            <div class="col-md-9 col-sm-8 col-xs-8">
                                                <select class="form-control" id="user_type" onchange="changevalue()">
                                                    <option value="user" {{ ($user->type == 'user') ? 'selected' : '' }}>User</option>
                                                    <option value="editor" {{ ($user->type == 'editor') ? 'selected' : '' }}>Editor</option>
                                                </select>  
                                            </div>
                                            @else
                                            <span class="col-md-9 col-sm-8 col-xs-8">
                                                {{ $user->type }}
                                            </span>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="row">
                                        <label style="text-align: right;" class="col-md-3 col-sm-4 col-xs-4">
                                            Member Since :
                                        </label>
                                        <span class="col-md-9 col-sm-8 col-xs-8">
                                            {{ $user->created_at }}
                                        </span>
                                    </div>

                                    <div class="row">
                                        <label style="text-align: right;" class="col-md-3 col-sm-4 col-xs-4">
                                            About Me :
                                        </label>
                                        <span class="col-md-9 col-sm-8 col-xs-8">
                                            {{ $user->user_descr }}
                                        </span>
                                    </div>

                                    <div class="ln_solid"></div>

                                    <div class="row">
                                        <form id="demo-form2" data-parsley-validate class="form-horizontal form-label-left" method="post" action="{{url('admin/user/edit/'.$user->id)}}">
                                            {{csrf_field()}}
                                            <input name="type" id="hidden_user_type" hidden>
                                            <div class="form-group">
                                                <label class="control-label col-md-3 col-sm-4 col-xs-12" for="curr-pass">
                                                    About Author<br><small>(By Editor) </small>
                                                </label>
                                                <div class="col-md-9 col-sm-12 col-xs-12">
                                                    <textarea rows="8" name="editor_descr" id="editor_descr" class="form-control">{{isset($user->editor_descr) ? $user->editor_descr : ''}}</textarea>
                                                </div>
                                            </div>
                                            
                                            
                                            <div class="form-group">
                                                <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                                                    <button type="submit" class="btn btn-success">Save</button>
                                                </div>
                                            </div>

                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <!-- Parsley -->
    <script src="../vendors/parsleyjs/dist/parsley.min.js"></script>

    <script type="text/javascript">
    function changevalue()
    {
        document.getElementById("hidden_user_type").value = document.getElementById("user_type").value;
    }
    </script>
@endsection

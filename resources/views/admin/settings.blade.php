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
                            <h3>Settings</h3>
                        </div>

                        <div class="row">
                            <div class="col-sm-12">
                                @include('admin.includes.errors')
                            </div>
                        </div>

                        @if(Session::has('message'))
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="alert alert-success">
                                        <strong>Success!</strong> {{Session::get('message')}}
                                    </div>
                                </div>
                            </div>
                        @endif

                        @if(Session::has('error'))
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="alert alert-danger">
                                        <strong>Error!</strong> {{Session::get('error')}}
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>

                    <div class="x_panel">
                        <div class="x_title">
                            <h2>My Profile <span style="text-align: right;"> / میری پروفائل<span></h2>
                            <ul class="nav navbar-right panel_toolbox">
                                <li class="pull-right"><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                            </ul>
                            <div class="clearfix"></div>
                        </div>

                        <div class="x_content">
                            <div class="row" >
                                <div class="col-sm-12">
                                    <div class="row">
                                        <h1 style="text-align: center;">
                                            {{ $user->name }}
                                        </h1><hr>
                                        <!-- <div>
                                            <img width="100%" src="{{ isset($user->avatar) ? url('$user->avatar') : url('/images/user.jpg')}}" alt="User Avatar">
                                        </div> -->
                                        <div style="margin-top: -15px;" class="image-editor">
                                            <input type="file" class="cropit-image-input">
                                            
                                            <div style="margin: 0 auto" class="cropit-preview"></div>
                                            <div style="width: 330px; margin: 0 auto;">
                                                <div class="image-size-label">
                                                    <span>Resize image</span><span style="float: right;">تصویر کا سائز تبدیل کریں</span>
                                                </div>
                                                <input type="range" class="cropit-image-zoom-input">
                                                <a class="btn btn-default rotate-ccw"><span class="fa fa-rotate-left"></span></a>
                                                <a class="btn btn-default rotate-cw"><span class="fa fa-rotate-right"></span></a>

                                                <span class="pull-right">
                                                    <a class="btn btn-default select-image-btn">Change Image <span style="color: silver">|</span> تصویر داخل کریں</a>
                                                <!-- <a class="btn btn-success export">Upload</a> -->
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>


                                <div class="col-sm-12 col-xs-12">
                                    <hr>
                                    <div class="row">
                                        <label style="text-align: right;" class="col-md-3 col-sm-4 col-xs-4">
                                            Email :
                                        </label>
                                        <span style="text-align: center;" class="col-md-6 col-sm-4 col-xs-4">
                                            {{ $user->email }}
                                        </span>
                                        <label style="text-align: left;" class="col-md-3 col-sm-4 col-xs-4">
                                            : ای میل
                                        </label>
                                    </div>

                                    <div class="row">
                                        <label style="text-align: right;" class="col-md-3 col-sm-4 col-xs-4">
                                            Type :
                                        </label>
                                        <span style="text-align: center;" class="col-md-6 col-sm-4 col-xs-4">
                                            {{ ucfirst($user->type) }}
                                        </span>
                                        <label style="text-align: left;" class="col-md-3 col-sm-4 col-xs-4" for="curr-pass">
                                            : اکاؤنٹ کی قسم
                                        </label>
                                    </div>

                                    <div class="row">
                                        <label style="text-align: right;" class="col-md-3 col-sm-4 col-xs-4" for="curr-pass">
                                            Member Since :
                                        </label>
                                        <span style="text-align: center;" class="col-md-6 col-sm-4 col-xs-4">
                                            {{ $user->created_at }}
                                        </span>
                                        <label style="text-align: left;" class="col-md-3 col-sm-4 col-xs-4" for="curr-pass">
                                            : رکنیت کی مدت
                                        </label>
                                    </div>

                                    <hr>
                                    @if(\Illuminate\Support\Facades\Auth::user()->type == 'user')
                                        <div class="row">
                                            <label style="text-align: right;" class="col-md-3 col-sm-4 col-xs-4" >
                                                Editor's Remarks :
                                            </label>
                                            <span style="text-align: center;" class="col-md-6 col-sm-4 col-xs-4">
                                            {{ $user->editor_descr }}
                                        </span>
                                            <label style="text-align: left;" class="col-md-3 col-sm-4 col-xs-4">
                                                : ایڈیٹر کے ریمارکس
                                            </label>
                                        </div>
                                        <div class="ln_solid"></div>
                                    @endif

                                    <div class="row">
                                        <form id="demo-form2" class="form-horizontal form-label-left" method="post" action="{{url('settings/user/edit/')}}">
                                            {{csrf_field()}}

                                            <input type="hidden" name="image-data" class="hidden-image-data" value="{{ isset($errors) ? old('image-data') : ''}}" />

                                            <div class="form-group">
                                                <label class="control-label col-md-3 col-sm-4 col-xs-12" for="user_descr">
                                                    About Me<br><small></small>
                                                </label>
                                                <div class="col-md-6 col-sm-6 col-xs-12">
                                                    <textarea rows="8" name="user_descr" id="user_descr" class="form-control col-md-7 col-xs-12">{{isset($user->user_descr) ? $user->user_descr : ''}}</textarea>
                                                </div>
                                                <label style="text-align: left" class="control-label col-md-3 col-sm-4 col-xs-12" for="user_descr">
                                                    میرے بارے میں<br><small></small>
                                                </label>
                                            </div>

                                            <div class="form-group">
                                                <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                                                    <a href="#" onclick="submitFunc(event)" class="btn btn-success">Submit</a>
                                                </div>
                                            </div>

                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="x_panel">
                        <div class="x_title">
                            <h2>Change Password </h2>
                            <ul class="nav navbar-right panel_toolbox">
                                <li class="pull-right"><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                            </ul>
                            <div class="clearfix"></div>
                        </div>
                        <div class="x_content">
                            <br />
                            <form class="form-horizontal form-label-left" method="post" action="{{url('settings/changepassword')}}">
                                {{csrf_field()}}

                                <div class="form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="curr-pass">Current Password <span class="required">*</span>
                                    </label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <input type="password" name="curr-pass" id="curr-pass" required="required" class="form-control col-md-7 col-xs-12">
                                    </div>
                                    <label style="text-align: left" class="control-label col-md-3 col-sm-3 col-xs-12" for="curr-pass"><span class="required">*</span> موجودہ پاسورڈ
                                    </label>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="new-pass">New Password <span class="required">*</span>
                                    </label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <input type="password" id="new-pass" name="new-pass" required="required" class="form-control col-md-7 col-xs-12">
                                    </div>
                                    <label style="text-align: left" class="control-label col-md-3 col-sm-3 col-xs-12" for="new-pass"><span class="required">*</span> نیا پاسورڈ</label>
                                </div>
                                <div class="form-group">
                                    <label for="re-new-pass" class="control-label col-md-3 col-sm-3 col-xs-12">Retype Password <span class="required">*</span>
                                    </label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <input id="re-new-pass" name="new-pass_confirmation" required="required" data-parsley-equalto="#new-pass" class="form-control col-md-7 col-xs-12" type="password" name="re-new-pass">
                                    </div>
                                    <label style="text-align: left" for="re-new-pass" class="control-label col-md-3 col-sm-3 col-xs-12"><span class="required">*</span> دوبارہ پاسوورڈ لکھئے 
                                    </label>
                                </div>

                                <div class="ln_solid"></div>
                                <div class="form-group">
                                    <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                                        <button type="submit" class="btn btn-success">Submit</button>
                                    </div>
                                </div>

                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('css')
    <!-- bootstrap-wysiwyg -->
    <link href="{{ url('vendors/google-code-prettify/bin/prettify.min.css') }}" rel="stylesheet">

    <!-- Switchery -->
    <link href="{{ url('vendors/switchery/dist/switchery.min.css') }}" rel="stylesheet">

    <!-- cropit -->
    <style>
        .cropit-preview {
            background-color: #f8f8f8;
            background-size: cover;
            border: 1px solid #ccc;
            border-radius: 3px;
            margin-top: -20px;
            height: 320px;
            width: 330px;
        }

        .cropit-preview-image-container {
            cursor: move;
        }

        .image-size-label {
            margin-top: 10px;
        }

        /* Hide file input */
        input.cropit-image-input {
            visibility: hidden;
        }

    </style>
@endsection

@section('js')
    <!-- Parsley -->
    <!-- <script src="../vendors/parsleyjs/dist/parsley.min.js"></script> -->

    <!-- cropit -->
    <script src="{{ url('vendors/cropit/dist/jquery.cropit.js') }}"></script>

    <script>
        $(function() {
            $('.image-editor').cropit({
                smallImage: 'allow',
                maxZoom: 2,
                // freeMove true, 
                imageState: {
                    src: '{{ isset($user->avatar) ? url('images/users/'.$user->avatar) : '' }}{{ isset($errors) ? old('image-data') : ''}}',
                },
                // onImageLoaded: function() {
                //     var imageData = $('.image-editor').cropit('export');
                //     $('.hidden-image-data').val(imageData);
                // },
            });

            $('.rotate-cw').click(function() {
                $('.image-editor').cropit('rotateCW');
            });
            $('.rotate-ccw').click(function() {
                $('.image-editor').cropit('rotateCCW');
            });

            // $('.export').click(function() {
            //     var imageData = $('.image-editor').cropit('export');
            //     $('.hidden-image-data').val(imageData);
            // });
        });

        $('.select-image-btn').click(function() {
            $('.cropit-image-input').click();
        });

        function submitFunc(e) {
            e.preventDefault();
            var imageData = $('.image-editor').cropit('export');
            $('.hidden-image-data').val(imageData);

            document.getElementById('demo-form2').submit();
        }
    </script>
@endsection

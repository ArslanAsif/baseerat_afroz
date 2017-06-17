@extends('admin.layouts.admin_panel')

@section('content')
    <!-- page content -->
    <div class="right_col" role="main">
        <div class="">
            <div class="clearfix"></div>
            <div class="row">
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <div class="x_panel">
                        <div class="x_title">
                            <h2>{{ isset($cateData) ? 'Edit': 'Add'}} Category <small></small></h2>
                            <ul class="nav navbar-right panel_toolbox">
                                <li class="pull-right"><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                            </ul>
                            <div class="clearfix"></div>
                        </div>
                        <div class="x_content">
                            <br />
                                <form id="demo-form2" data-parsley-validate class="form-horizontal form-label-left" method="post" action="{{ isset($cateData) ? url('admin/category/edit/'.$cateData->id) : url('admin/category/add') }}">
                                    {{ csrf_field() }}
                                    <div class="form-group">
                                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="category">Category Name (English) <span class="required">*</span>
                                        </label>
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <input type="text" id="category_eng" value="{{ isset($cateData) ? $cateData->title_eng : '' }}" name="category_eng" required="required" placeholder="Write category name in english" class="form-control col-md-7 col-xs-12">

                                            <input type="hidden" value="{{ isset($cateData) ? $cateData->id : '' }}" name="id" class="form-control col-md-7 col-xs-12">
                                            
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="category_ur">Category Name (Urdu)<span class="required">*</span>
                                        </label>
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <input style="direction: rtl" type="text" id="category_ur" value="{{ isset($cateData) ? $cateData->title_ur : '' }}" name="category_ur" required="required" placeholder="اردو میں قسم کا نام لکھیں" class="form-control col-md-7 col-xs-12">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="parent-category" class="control-label col-md-3 col-sm-3 col-xs-12">Parent Category (if any)</label>
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <select class="form-control" name="parent-category">
                                                <option></option>
                                                @foreach($categories as $category)
                                                    <option {{ isset($cateData) ? ($cateData->category_id == $category->id) ? 'selected' : '' : '' }} value="{{ $category->id }}">
                                                        {{ $category->title_eng.' - '.$category->title_ur  }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="priority">Priority <span class="required">*</span>
                                        </label>
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <input type="number" value="{{ isset($cateData) ? $cateData->priority : '' }}" id="priority" name="priority" required="required" class="form-control col-md-7 col-xs-12">
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <div class="col-md-9 col-sm-9 col-xs-12 col-md-offset-3 col-sm-offset-3">
                                            <div class="">
                                                <label>
                                                    <input name="active" type="checkbox" class="js-switch" {{ isset($cateData) ? ($cateData->active == 1) ? 'checked': '': '' }} /> Active
                                                </label>
                                            </div>
                                            <div class="">
                                                <label>
                                                    <input name="homepage" type="checkbox" class="js-switch" {{ isset($cateData) ? ($cateData->homepage == 1) ? 'checked': '': '' }} /> Show on Homepage
                                                </label>
                                            </div>
                                            <div class="">
                                                <label>
                                                    <input name="headline" type="checkbox" class="js-switch" {{ isset($cateData) ? ($cateData->headline == 1) ? 'checked': '': '' }} /> Show in Headlines
                                                </label>
                                            </div>
                                        </div>
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
    <!-- Switchery -->
    <link href="{{ url('vendors/switchery/dist/switchery.min.css') }}" rel="stylesheet">
@endsection

@section('js')
    <!-- Switchery -->
    <script src="{{ url('vendors/switchery/dist/switchery.min.js') }}"></script>
@endsection
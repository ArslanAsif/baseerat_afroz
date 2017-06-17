@extends('admin.layouts.admin_panel')

@section('content')
    <!-- page content -->
    <div class="right_col" role="main">
        <div class="clearfix"></div>
            <div class="row">
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <div class="x_panel">
                        <div class="x_title">
                            <h2>Spotlight <small></small></h2>
                            <ul class="nav navbar-right panel_toolbox">
                                <li class="pull-right"><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                            </ul>
                            <div class="clearfix"></div>
                        </div>
                        <div class="x_content">
                            <br />
                            <form class="form-horizontal form-label-left" method="post" action="{{ url('admin/homepage/spotlight') }}">
                                {{ csrf_field() }}
                                <?php $i = 1?>
                                @foreach($spotlights as $spotlight)
                                <div class="form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="category">Spotlight {{$i}}<span class="required">*</span>
                                    </label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <select class="form-control" name={{ "spotlight".$i++ }}>
                                            <option></option>
                                            @foreach($articles as $article)
                                                <option value="{{$article->id}}" {{ ($article->id == $spotlight->article_id) ? 'selected' : '' }}>{{$article->title}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                @endforeach

                                {{--<div class="form-group">--}}
                                    {{--<div class="col-md-9 col-sm-9 col-xs-12 col-md-offset-3 col-sm-offset-3">--}}
                                        {{--<div class="">--}}
                                            {{--<label>--}}
                                                {{--<input name="active" type="checkbox" class="js-switch" {{ isset($cateData) ? ($cateData->active == 1) ? 'checked': '': '' }} /> Active--}}
                                            {{--</label>--}}
                                        {{--</div>--}}
                                    {{--</div>--}}
                                {{--</div>--}}

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

            <div class="row">
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <div class="x_panel">
                        <div class="x_title">
                            <h2>Highlights <small></small></h2>
                            <ul class="nav navbar-right panel_toolbox">
                                <li class="pull-right"><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                            </ul>
                            <div class="clearfix"></div>
                        </div>
                        <div class="x_content">
                            <br />
                            <form class="form-horizontal form-label-left" method="post" action="{{ url('admin/homepage/highlight') }}">
                                {{ csrf_field() }}
                                <?php $i = 1?>
                                @foreach($highlights as $highlight)
                                    <div class="form-group">
                                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="category">Highlight {{$i}}<span class="required">*</span>
                                        </label>
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <select class="form-control" name={{ "highlight".$i++ }}>
                                                <option></option>
                                                @foreach($articles as $article)
                                                    <option value="{{$article->id}}" {{ ($article->id == $highlight->article_id) ? 'selected' : '' }}>{{$article->title}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                @endforeach

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

            <div class="row">
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <div class="x_panel">
                        <div class="x_title">
                            <h2>Editor's Pick <small></small></h2>
                            <ul class="nav navbar-right panel_toolbox">
                                <li class="pull-right"><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                            </ul>
                            <div class="clearfix"></div>
                        </div>
                        <div class="x_content">
                            <br />
                            <form class="form-horizontal form-label-left" method="post" action="{{ url('admin/homepage/editorpick') }}">
                                {{ csrf_field() }}
                                @foreach($editorpicks as $editorpick)
                                    <div class="form-group">
                                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="category">Editorpick {{$i}}<span class="required">*</span>
                                        </label>
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <select class="form-control" name={{ "editorpick".$i++ }}>
                                                <option></option>
                                                @foreach($articles as $article)
                                                    <option value="{{$article->id}}" {{ ($article->id == $editorpick->article_id) ? 'selected' : '' }}>{{$article->title}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                @endforeach

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

            <div class="row">
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <div class="x_panel">
                        <div class="x_title">
                            <h2>Category <small></small></h2>
                            <ul class="nav navbar-right panel_toolbox">
                                <li class="pull-right"><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                            </ul>
                            <div class="clearfix"></div>
                        </div>
                        <div class="x_content">
                            <br />
                            <form class="form-horizontal form-label-left" method="post" action="{{ url('admin/homepage/category') }}">
                                {{ csrf_field() }}
                                @foreach($hp_categories as $hp_category)
                                    <div class="form-group">
                                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="category">Category {{$i}}<span class="required">*</span>
                                        </label>
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <select class="form-control" name={{ "category".$i++ }}>
                                                <option></option>
                                                @foreach($categories as $category)
                                                    <option value="{{$category->id}}" {{ ($category->id == $hp_category->category_id) ? 'selected' : '' }}>{{$category->title_eng}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                @endforeach

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
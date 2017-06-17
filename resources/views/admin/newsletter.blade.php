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
                            <h2>Edit Newsletter <small><a href="{{ url('/admin/newsletter/today') }}" class="btn btn-sm btn-default">Add Today's News</a></small></h2>
                            

                            <ul class="nav navbar-right panel_toolbox">
                                <li class="pull-right"><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                            </ul>
                            <div class="clearfix"></div>
                        </div>
                        <div class="x_content">
                            <br/>

                            <form action="{{url('/admin/newsletter')}}" method="post" id="demo-form2" data-parsley-validate class="form-horizontal form-label-left">
                                {{ csrf_field() }}
                                @include('admin.includes.text_editor')
                                <div id="editor" class="editor-wrapper"><?= isset($content) ? $content : '' ?></div>
                                <textarea name="content" id="hidden_descr" style="display:none;"></textarea>
                                <div class="ln_solid"></div>
                                <div class="form-group">
                                    <button  class="btn btn-success pull-right" id="abouatUs">Send Newsletter <i class="fa fa-send"></i></button>
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
@endsection

@section('js')
    <!-- bootstrap-wysiwyg -->
    <script src="{{ url('vendors/bootstrap-wysiwyg/js/bootstrap-wysiwyg.min.js') }}"></script>
    <script src="{{ url('vendors/jquery.hotkeys/jquery.hotkeys.js') }}"></script>
    <script src="{{ url('vendors/google-code-prettify/src/prettify.js') }}"></script>

    <!-- bootstrap-wysiwyg -->
    <script>
        $(document).ready(function() {
            function initToolbarBootstrapBindings() {
                var fonts = ['Serif', 'Sans', 'Arial', 'Arial Black', 'Courier',
                            'Courier New', 'Comic Sans MS', 'Helvetica', 'Impact', 'Lucida Grande', 'Lucida Sans', 'Tahoma', 'Times',
                            'Times New Roman', 'Verdana'
                        ],
                        fontTarget = $('[title=Font]').siblings('.dropdown-menu');
                $.each(fonts, function(idx, fontName) {
                    fontTarget.append($('<li><a data-edit="fontName ' + fontName + '" style="font-family:\'' + fontName + '\'">' + fontName + '</a></li>'));
                });
                $('a[title]').tooltip({
                    container: 'body'
                });
                $('.dropdown-menu input').click(function() {
                    return false;
                })
                        .change(function() {
                            $(this).parent('.dropdown-menu').siblings('.dropdown-toggle').dropdown('toggle');
                        })
                        .keydown('esc', function() {
                            this.value = '';
                            $(this).change();
                        });

                $('[data-role=magic-overlay]').each(function() {
                    var overlay = $(this),
                            target = $(overlay.data('target'));
                    overlay.css('opacity', 0).css('position', 'absolute').offset(target.offset()).width(target.outerWidth()).height(target.outerHeight());
                });

                if ("onwebkitspeechchange" in document.createElement("input")) {
                    var editorOffset = $('#editor').offset();

                    $('.voiceBtn').css('position', 'absolute').offset({
                        top: editorOffset.top,
                        left: editorOffset.left + $('#editor').innerWidth() - 35
                    });
                } else {
                    $('.voiceBtn').hide();
                }
            }

            function showErrorAlert(reason, detail) {
                var msg = '';
                if (reason === 'unsupported-file-type') {
                    msg = "Unsupported format " + detail;
                } else {
                    console.log("error uploading file", reason, detail);
                }
                $('<div class="alert"> <button type="button" class="close" data-dismiss="alert">&times;</button>' +
                        '<strong>File upload error</strong> ' + msg + ' </div>').prependTo('#alerts');
            }

            initToolbarBootstrapBindings();

            $('#editor').wysiwyg({
                fileUploadError: showErrorAlert
            });

            window.prettyPrint;
            prettyPrint();
        });
        //-- copy html to hidden textarea
        $('#editor').bind("DOMSubtreeModified",function(){
            $('#hidden_descr').html(
                    $("#editor").html()
            );
        });
    </script>
    <!-- /bootstrap-wysiwyg -->
@endsection
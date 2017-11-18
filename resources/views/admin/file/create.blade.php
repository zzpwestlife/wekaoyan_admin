@extends("admin.layout.main")

@section('add_css')
    {!! Html::style('/bower_components/bootstrap-switch/dist/css/bootstrap3/bootstrap-switch.min.css') !!}
    {!! Html::style('/dropzone/dist/min/dropzone.min.css') !!}
@endsection

@section("content")
    <!-- Main content -->
    <section class="content">
        <!-- Small boxes (Stat box) -->
        <div class="row">
            <div class="col-lg-10 col-xs-6">
                <div class="box box-info">
                    <div class="box-header with-border">
                        <h3 class="box-title">@if(isset($file))编辑文件@else增加文件@endif</h3>
                    </div>
                    <!-- /.box-header -->
                    @if(isset($file) && !empty($file->uri))
                        {{--NOTHING--}}
                    @else
                        <div class="dropzone dz-clickable" id="myDrop">
                            <div class="dz-default dz-message" data-dz-message="">
                                <span style="font-size: large">点击此处或拖拽文件到此处（一个文件）</span>
                            </div>
                        </div>
                @endif

                <!-- form start -->
                    <form role="form" action="/admin/files/store" method="POST" id="form-item">
                        {{csrf_field()}}
                        <div class="box-body">
                            <input type="hidden" value="{{$file->id or 0}}" name="id">

                            <div class="form-group col-sm-12">
                                <label for="user_id" class="control-label col-sm-2">选择上传者<span
                                            class="required-field">*</span></label>

                                <div class="col-sm-4 col-md-4 col-lg-4">
                                    <select id="user_id" name="user_id" class="form-control select2">
                                        {{--<option value="">请选择</option>--}}
                                        @foreach($users as $key => $value)
                                            <option value="{{$value->id}}"
                                                    @if($value->id == $file->user_id) selected
                                                    @endif>{{$value->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="form-group col-sm-12">
                                <label for="forum_id" class="control-label col-sm-2">选择论坛<span
                                            class="required-field">*</span></label>

                                <div class="col-sm-4 col-md-4 col-lg-4">
                                    <select id="forum_id" name="forum_id" class="form-control select2">
                                        {{--<option value="">请选择</option>--}}
                                        @foreach($forums as $key => $value)
                                            <option value="{{$value->id}}"
                                                    @if($value->id == $file->forum_id) selected
                                                    @endif>{{$value->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="form-group col-sm-12">
                                <label for="type" class="control-label col-sm-2">选择文件类型<span
                                            class="required-field">*</span></label>

                                <div class="col-sm-4 col-md-4 col-lg-4">
                                    <select id="type" name="type" class="form-control select2">
                                        @foreach($fileTypes as $key => $value)
                                            <option value="{{$key}}"
                                                    @if($key == $file->type) selected
                                                    @endif>{{$value}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="form-group col-sm-12">
                                <label for="filename" class="col-sm-2 control-label">文件名<span
                                            class="required-field">*</span></label>

                                <div class="col-sm-6">
                                    <input type="text" class="form-control" name="filename" id="filename"
                                           value="@if(!empty($file)){{$file->filename}}@endif">
                                    <input type="hidden" class="form-control" name="path" id="path"
                                           value="@if(!empty($file)){{$file->path}}@endif">
                                    <input type="hidden" class="form-control" name="uri" id="uri"
                                           value="@if(!empty($file)){{$file->uri}}@endif">
                                    <input type="hidden" class="form-control" name="hash" id="hash"
                                           value="@if(!empty($file)){{$file->hash}}@endif">
                                </div>
                            </div>

                            <div class="form-group col-sm-12">
                                <label for="downloads" class="col-sm-2 control-label">下载量<span
                                            class="required-field">*</span></label>

                                <div class="col-sm-2">
                                    <input type="number" class="form-control" name="downloads" id="downloads" min="0"
                                           value="@if(!empty($file) && !empty($file->downloads)){{$file->downloads}}@endif">
                                </div>
                            </div>

                        </div>
                        <!-- /.box-body -->
                        @include("admin.layout.error")
                        <div class="box-footer" style="margin-left: 178px;">
                            <a class="btn btn-icon btn-default m-b-5" href="/admin/files"
                               title="取消">取消
                            </a>
                            &emsp;
                            <button type="submit" class="btn btn-primary">提交</button>
                        </div>
                        <!-- /.box-footer -->
                    </form>

                </div>
            </div>
        </div>
    </section>

@endsection

@section('add_script')
    {!! Html::script('/bower_components/bootstrap-switch/dist/js/bootstrap-switch.min.js') !!}
    <script src="/dropzone/dist/min/dropzone.min.js"></script>
@endsection

@section('script')

    <script type="text/javascript">
        Dropzone.autoDiscover = false; // 这一行一定要放在ready之前
        $(document).ready(function () {
            $('#name').focus();
            $("#form-item").validate();
            $(".select2").select2({language: "zh-CN"});
            $("div.switch input[type=\"checkbox\"]").not("[data-switch-no-init]").bootstrapSwitch();
            var fileMaxSize = 20; // MB

            var myDropzone = new Dropzone("div#myDrop", {
                url: "/admin/files/upload",
                paramName: "file", // The name that will be used to transfer the file
                maxFilesize: fileMaxSize, // MB
                maxFiles: 1, // 一个一个来
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            myDropzone.on('addedfile', function (file) {
                if (file.size > 1024 * 1024 * fileMaxSize) {
                    alert('文件大小不能超过 ' + fileMaxSize + 'M');
                    myDropzone.removeFile(file);
                }
                file.previewElement.addEventListener("click", function () {
//                    var filename = $(this).find('.dz-filename')[0].innerText;
//                    console.log(file);
                    var path = $('#path').val();
                    var filename = $('#filename').val();
                    if (window.confirm('你确定要删除 ' + file.name + ' 吗？')) {
                        $.ajax({
                            type: "GET",
                            url: "/admin/files/delete",
                            data: {path: path},
                            dataType: "JSON",
                            success: function (data) {
//                                console.log(data);
                                if (0 == data.error) {
                                    myDropzone.removeFile(file);
                                } else {
                                    alert('删除失败，稍后重试');
                                }
                            }
                        });
                    } else {
                        return false;
                    }
                });
            });

            myDropzone.on('success', function (file, response) {
//                console.log(file);
//                console.log(response);
                if (response.errno == 0) {
//                    alert('文件上传成功');
                    $('#filename').attr('value', response.data['original_filename']);
                    $('#path').attr('value', response.data['path']);
                    $('#uri').attr('value', response.data['uri']);
                    $('#hash').attr('value', response.data['file_hash']);
                } else {
                    alert(response.msg);
                    myDropzone.removeFile(file);
                }
            });

            myDropzone.on('error', function (file, errorMessage) {
//                console.log(errorMessage);
            });
            myDropzone.on('removefile', function (file) {
                alert('remove file');
            });
        });
    </script>
@endsection
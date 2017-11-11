@extends("admin.layout.main")

@section('add_css')
    {!! Html::style('/bower_components/bootstrap-switch/dist/css/bootstrap3/bootstrap-switch.min.css') !!}
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
                                        <option value="">请选择</option>
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
                                        <option value="">请选择</option>
                                        @foreach($forums as $key => $value)
                                            <option value="{{$value->id}}"
                                                    @if($value->id == $file->forum_id) selected
                                                    @endif>{{$value->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            {{--<div class="form-group col-sm-12">--}}
                            {{--<label for="course_type" class="control-label col-sm-2">选择课程类型<span--}}
                            {{--class="required-field">*</span></label>--}}

                            {{--<div class="col-sm-4 col-md-4 col-lg-4 switch">--}}
                            {{--<input type="checkbox" id="course_type" name="course_type" value="1"--}}
                            {{--@if($file->type==1) checked="checked"--}}
                            {{--@endif data-on-text="公开课"--}}
                            {{--data-off-text="专业课"/>--}}
                            {{--</div>--}}
                            {{--</div>--}}

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
                                {{--<div class="col-sm-4 col-md-4 col-lg-4 switch">--}}
                                {{--<input type="checkbox" id="type" name="type" value="0"--}}
                                {{--@if($file->type==1) checked="checked"--}}
                                {{--@endif data-on-text="资料"--}}
                                {{--data-off-text="真题答案"/>--}}
                                {{--</div>--}}
                            </div>


                            {{--<div class="form-group col-sm-12" id="wrapper_upload_file">--}}
                            {{--<label for="input_file" class="control-label col-sm-2">文件<span--}}
                            {{--class="required-field">*</span></label>--}}

                            {{--<div class="col-sm-4">--}}

                            {{--<div id="media_file_preview" class="media-preview">--}}
                            {{--@if ($file->filename)--}}
                            {{--<span class="preview"><video src="{{$file->file_path}}" controls="controls">您的浏览器不支持 video 标签。</video></span>--}}
                            {{--@else--}}
                            {{--<img src="/images/nofile.png"--}}
                            {{--style="top:45px;height:160px;min-width:160px;max-width:320px">--}}
                            {{--@endif--}}
                            {{--</div>--}}

                            {{--<div class="media-actions fileupload-buttonbar">--}}

                            {{--<button type="button" title="取消"--}}
                            {{--class="btn btn-default cancel">--}}
                            {{--<i class="glyphicon glyphicon-remove"></i>--}}
                            {{--<span class="hidden-xs">取消</span>--}}
                            {{--</button>--}}

                            {{--<div class="btn btn-primary btn-file" id="choose-file">--}}
                            {{--<i class="glyphicon glyphicon-folder-open"></i>--}}
                            {{--<span class="hidden-xs">选择</span>--}}
                            {{--<input type="file" name="file" accept="*/*" title="选择文件" id="input_file"--}}
                            {{--class="">--}}
                            {{--</div>--}}

                            {{--<button type="submit" title="上传" id="btn_upload_file" style="display:none;"--}}
                            {{--class="btn btn-success start">--}}
                            {{--<i class="glyphicon glyphicon-upload"></i>--}}
                            {{--<span>上传</span>--}}
                            {{--</button>--}}

                            {{--<input type="hidden" id="target_file_name" name="target_file_name">--}}

                            {{--</div>--}}
                            {{--</div>--}}
                            {{--</div>--}}

                            <div class="form-group col-sm-12">
                                <label for="filename" class="col-sm-2 control-label">文件名<span
                                            class="required-field">*</span></label>

                                <div class="col-sm-6">
                                    <input type="text" class="form-control" name="filename" id="filename"
                                           value="@if(!empty($file)){{$file->filename}}@endif">
                                </div>
                            </div>

                            <div class="form-group col-sm-12">
                                <label for="downloads" class="col-sm-2 control-label">下载量<span
                                            class="required-field">*</span></label>

                                <div class="col-sm-2">
                                    <input type="number" class="form-control" name="downloads" id="downloads"
                                           value="@if(!empty($file)){{$file->downloads}}@endif">
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
@endsection

@section('script')

    <script type="text/javascript">
        $(document).ready(function () {
            $('#name').focus();
            $("#form-item").validate();
            $(".select2").select2({language: "zh-CN"});
            $("div.switch input[type=\"checkbox\"]").not("[data-switch-no-init]").bootstrapSwitch();
        });
    </script>
@endsection
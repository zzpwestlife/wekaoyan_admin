@extends("admin.layout.main")
@section('add_css')
    <style type="text/css">
    </style>
@endsection

@section("content")
    <!-- Main content -->
    <section class="content">
        <!-- Small boxes (Stat box) -->
        <div class="row">
            <div class="col-lg-10 col-xs-6">
                <div class="box box-info">
                    <div class="box-header with-border">
                        <h3 class="box-title">@if(isset($question->id))编辑问题@else增加问题@endif</h3>
                    </div>
                    <!-- /.box-header -->
                    <!-- form start -->
                    <form role="form" action="" id="form-item">
                        {{csrf_field()}}
                        <div class="box-body">

                            <div class="form-group col-sm-12">
                                <label for="forum_id" class="control-label col-sm-2">选择论坛<span
                                            class="required-field">*</span></label>

                                <div class="col-sm-4 col-md-4 col-lg-4">
                                    <select id="forum_id" name="forum_id" class="form-control select2">
                                        <option value="">请选择</option>
                                        @foreach($forums as $key => $value)
                                            <option value="{{$value->id}}"
                                                    @if($value->id == $question->forum_id) selected
                                                    @endif>{{$value->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="form-group col-sm-12">
                                <label for="user_id" class="control-label col-sm-2">选择作者<span
                                            class="required-field">*</span></label>

                                <div class="col-sm-4 col-md-4 col-lg-4">
                                    <select id="user_id" name="user_id" class="form-control select2">
                                        <option value="">请选择</option>
                                        @foreach($users as $key => $value)
                                            <option value="{{$value->id}}"
                                                    @if($value->id == $question->user_id) selected
                                                    @endif>{{$value->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="form-group col-sm-12">
                                <label for="title" class="col-sm-2 control-label">标题<span
                                            class="required-field">*</span></label>

                                <div class="col-sm-4">
                                    <input type="hidden" value="{{$question->id or 0}}" name="id">
                                    <input type="text" class="form-control" name="title" id="title" minlength="4"
                                           required
                                           value="@if(!empty($question)){{$question->title}}@endif" placeholder="请输入标题">
                                </div>
                            </div>

                            <div class="form-group col-sm-12">
                                <label for="editor" class="col-sm-2 control-label">问题内容<span
                                            class="required-field">*</span></label>

                                <div class="col-sm-10">
                                    <div id="editor">
                                        @if(!empty($question)){!! $question->content !!}@endif
                                    </div>
                                </div>
                            </div>

                        </div>
                        <!-- /.box-body -->
                        @include("admin.layout.error")
                        <div class="box-footer" style="margin-left: 268px;">
                            <a class="btn btn-icon btn-default m-b-5" href="/admin/questions"
                               title="取消">取消
                            </a>
                            &emsp;
                            <button type="button" class="btn btn-primary btn-save">提交</button>
                        </div>
                        <!-- /.box-footer -->
                    </form>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('script')
    <script type="text/javascript">
        $(document).ready(function () {
            $('#name').focus();
            $(".select2").select2({language: "zh-CN"});

            var E = window.wangEditor;
            var editor = new E('#editor');
            editor.customConfig.uploadImgServer = '/admin/questions/image/upload'; // 上传图片到服务器
            editor.customConfig.uploadImgHeaders = {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            };
            editor.customConfig.uploadFileName = 'wangEditorImg';
            // 将图片大小限制为 1M
            editor.customConfig.uploadImgMaxSize = 1024 * 1024;
            // 限制一次最多上传 5 张图片
            editor.customConfig.uploadImgMaxLength = 5;
            // 隐藏“网络图片”tab
            editor.customConfig.showLinkImg = false;
            editor.customConfig.zIndex = 1;
            editor.create();

            $('button.btn-save').click(function () {
                var forumId = $('#forum_id').val();
                var userId = $('#user_id').val();
                var title = $('#title').val();
                var content = editor.txt.html();

                console.log(forumId, userId, content);
                if (forumId < 1 || userId < 1 || content == '') {
                    alert('参数不完整');
                } else {
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });
                    $.ajax({
                        type: "POST",
                        url: "/admin/questions/store",
                        data: {
                            'forum_id': forumId,
                            'user_id': userId,
                            'title': title,
                            'content': content
                        },
                        dataType: "JSON",
                        beforeSend: null,
                        success: function (data) {
                            console.log(data);
                            if (0 == data.error) {
                                location.href = "/admin/questions";
                            }
                        },
                        error: function (xhr) {
                            console.log(xhr);
                            alert("错误提示： " + xhr.status + " " + xhr.msg);
                        }
                    });
                }
            });
        });
    </script>
@endsection
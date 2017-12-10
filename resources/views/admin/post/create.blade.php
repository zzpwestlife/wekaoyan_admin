@extends("admin.layout.main")
@section('add_css')
    {!! Html::style('/datetimepicker-master/build/jquery.datetimepicker.min.css') !!}
@endsection

@section("content")
    <!-- Main content -->
    <section class="content">
        <!-- Small boxes (Stat box) -->
        <div class="row">
            <div class="col-lg-10 col-xs-6">
                <div class="box box-info">
                    <div class="box-header with-border">
                        <h3 class="box-title">@if(isset($post->id))编辑帖子@else增加帖子@endif</h3>
                    </div>
                    <!-- /.box-header -->
                    <!-- form start -->
                    <form role="form" action="" id="form-item">
                        {{csrf_field()}}
                        <input type="hidden" value="{{$post->id or 0}}" name="id" id="id">
                        <div class="box-body">

                            <div class="form-group col-sm-12">
                                <label for="title" class="col-sm-2 control-label">帖子标题<span
                                            class="required-field">*</span></label>

                                <div class="col-sm-8">
                                    <input type="text" class="form-control" name="title" id="title"
                                           value="@if(!empty($post)){{$post->title}}@endif">
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
                                                    @if($value->id == $post->forum_id) selected
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
                                        {{--<option value="">请选择</option>--}}
                                        @foreach($users as $key => $value)
                                            <option value="{{$value->id}}"
                                                    @if($value->id == $post->user_id) selected
                                                    @endif>{{$value->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="form-group col-sm-12">
                                <label for="count" class="col-sm-2 control-label">阅读数<span
                                            class="required-field">*</span></label>

                                <div class="col-sm-4">
                                    <input type="number" class="form-control" name="count" id="count"
                                           value="@if(!empty($post)){{$post->count}}@endif">
                                </div>
                            </div>

                            <div class="form-group col-sm-12">
                                <label for="updated_at" class="col-sm-2 control-label">更新时间<span
                                            class="required-field">*</span></label>

                                <div class="col-sm-4 form-group">
                                    <input type='text' class="form-control updated_at" id="datetimepicker" name="updated_at"
                                           placeholder="不填默认为当期时间" value="{{$post->updated_at or ''}}"/>
                                </div>
                            </div>

                            <div class="form-group  col-sm-12">
                                <label for="editor" class="col-sm-2 control-label">内容预览<span
                                            class="required-field">*</span></label>

                                <div class="col-sm-10 content_article">
                                    <p>
                                        @if(!empty($post) && !empty($post->postContent)){!! $post->postContent->content !!}@endif
                                    </p>
                                </div>
                            </div>

                            <div class="form-group  col-sm-12">
                                <label for="editor" class="col-sm-2 control-label">内容编辑<span
                                            class="required-field">*</span></label>

                                <div class="col-sm-10">
                                    <div id="editor">
                                        <p>
                                            @if(!empty($post) && !empty($post->postContent)){!! $post->postContent->content !!}@endif
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- /.box-body -->
                        @include("admin.layout.error")
                        <div class="box-footer" style="margin-left: 268px;">
                            <a class="btn btn-icon btn-default m-b-5" href="/admin/posts"
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

@section('add_script')
    {!! Html::script('/datetimepicker-master/build/jquery.datetimepicker.full.min.js') !!}
@endsection

@section('script')
    <script type="text/javascript">
        $(document).ready(function () {
            $.datetimepicker.setLocale('zh');
            $('#datetimepicker').datetimepicker({
                'step': 1,
                maxDate: '+1970/01/02'//tomorrow is maximum date calendar
            });

            $('.content_article h1,.content_article h2,.content_article h3,.content_article h4,.content_article h5,.content_article p').css('text-align', 'justify');
            $('.content_article h1').css('font-weight', '400');
            $('.content_article h2').css('font-weight', '400');
            $('.content_article h3').css('font-weight', '400');
            $('.content_article h4').css('font-weight', '300');
            $('.content_article h5').css('font-weight', '400');
            $('.content_article p').css('font-weight', '400');
            $('.content_article h1,.content_article h2,.content_article h3,.content_article h4,.content_article h5').css('font-family', 'PingFang SC');

            $('.content_article h2').css('line-height', '4rem');
            $('.content_article h3').css('line-height', '3.2rem');
            $('.content_article h4').css('line-height', '2.8rem');
            $('.content_article h5').css('line-height', '2rem');
            $('.content_article p').css('line-height', '2.5rem');
            $('.content_article p').css('font-size', '1.5rem');
            $('.content_article p').css('margin-bottom', '2rem');
            $('.content_article table').css('width', '95%');

            $('#name').focus();
            $(".select2").select2({language: "zh-CN"});

            var E = window.wangEditor;
            var editor = new E('#editor');
            editor.customConfig.uploadImgServer = '/admin/posts/image/upload';  // 上传图片到服务器
            editor.customConfig.uploadImgHeaders = {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            };
            editor.customConfig.uploadFileName = 'wangEditorImg';
            // 将图片大小限制为 10M
            editor.customConfig.uploadImgMaxSize = 10 * 1024 * 1024;
            // 限制一次最多上传 5 张图片
            editor.customConfig.uploadImgMaxLength = 5;
            // 隐藏“网络图片”tab
            editor.customConfig.showLinkImg = false;
            editor.customConfig.zIndex = 1;
            editor.customConfig.menus = [
                'head',  // 标题
                'bold',  // 粗体
                'italic',  // 斜体
                'underline',  // 下划线
                'strikeThrough',  // 删除线
                'foreColor',  // 文字颜色
                'backColor',  // 背景颜色
                'link',  // 插入链接
                'list',  // 列表
                'justify',  // 对齐方式
                'quote',  // 引用
                'emoticon',  // 表情
                'image',  // 插入图片
                'table',  // 表格
//                'video',  // 插入视频
                'code',  // 插入代码
                'undo',  // 撤销
                'redo'  // 重复
            ];
            editor.create();

            $('button.btn-save').click(function () {
                $('button.btn-save').attr('disabled', 'disabled');
                $('button.btn-save').text('保存中...');

                var id = $('#id').val();
                var forumId = $('#forum_id').val();
                var userId = $('#user_id').val();
                var title = $('#title').val();
                var count = $('#count').val();
                var updatedAt = $('.updated_at').val();
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
                        url: "/admin/posts/store",
                        data: {
                            'id': id,
                            'forum_id': forumId,
                            'user_id': userId,
                            'title': title,
                            'count': count,
                            'updated_at': updatedAt,
                            'content': content
                        },
                        dataType: "JSON",
                        beforeSend: null,
                        success: function (data) {
                            console.log(data);
                            if (0 == data.error) {
                                location.href = "/admin/posts";
                            }
                        },
                        error: function (xhr) {
                            console.log(xhr);
                            $('button.btn-save').removeAttr('disabled');
                            $('button.btn-save').text('确定');
                            alert("错误提示： " + xhr.status + " " + xhr.msg);
                        }
                    });
                }
            });
        });
    </script>
@endsection
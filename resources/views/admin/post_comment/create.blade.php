@extends("admin.layout.main")

@section("content")
    <!-- Main content -->
    <section class="content">
        <!-- Small boxes (Stat box) -->
        <div class="row">
            <div class="col-lg-10 col-xs-6">
                <div class="box box-info">
                    <div class="box-header with-border">
                        <h3 class="box-title">@if(isset($postComment->id))编辑经验贴评论@else增加经验贴评论@endif</h3>
                        @if(count($post)):
                        <a href="/admin/posts/create/{{$post->id}}">{{$post->title}}</a>
                        @endif
                    </div>
                    <!-- /.box-header -->
                    <!-- form start -->
                    <form role="form" action="/admin/post_comments/store" method="POST" id="form-item">
                        {{csrf_field()}}
                        <div class="box-body">
                            <input type="hidden" name="post_id" id="post_id" value="{{$post->id}}">
                            <div class="form-group col-sm-12">
                                <label for="content" class="col-sm-2 control-label">经验贴评论内容<span
                                            class="required-field">*</span></label>

                                <div class="col-sm-4">
                                    <input type="hidden" value="{{$postComment->id or 0}}" name="id">
                                    <textarea rows="6" class="form-control" name="content" id="content"
                                              minlength="4">@if(!empty($postComment)){{$postComment->content}}@endif</textarea>
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
                                                    @if($value->id == $postComment->user_id) selected
                                                    @endif>{{$value->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            {{--<div class="form-group col-sm-12">--}}
                            {{--<label for="post_id" class="control-label col-sm-2">选择经验贴<span--}}
                            {{--class="required-field">*</span></label>--}}

                            {{--<div class="col-sm-4 col-md-4 col-lg-4">--}}
                            {{--<select id="post_id" name="post_id" class="form-control select2">--}}
                            {{--<option value="">请选择</option>--}}
                            {{--@foreach($posts as $key => $value)--}}
                            {{--<option value="{{$value->id}}"--}}
                            {{--@if($value->id == $postComment->post_id) selected--}}
                            {{--@endif>{{$value->content}}</option>--}}
                            {{--@endforeach--}}
                            {{--</select>--}}
                            {{--</div>--}}
                            {{--</div>--}}

                        </div>
                        <!-- /.box-body -->
                        @include("admin.layout.error")
                        <div class="box-footer" style="margin-left: 168px;">
                            <a class="btn btn-icon btn-default m-b-5" href="/admin/post_comments?post_id={{$post->id}}"
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

@section('script')
    <script type="text/javascript">
        $(document).ready(function () {
            $('#name').focus();
            $("#form-item").validate();
            $(".select2").select2({language: "zh-CN"});
        });
    </script>
@endsection
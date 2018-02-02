@extends("layout.main")

@section("content")
    <!-- Main content -->
    <section class="content">
        <!-- Small boxes (Stat box) -->
        <div class="row">
            <div class="col-lg-10 col-xs-6">
                <div class="box box-info">
                    <div class="box-header with-border">
                        <h3 class="box-title">@if(isset($exam->id))编辑回复@else增加回复@endif</h3>
                        @if(count($exam)):
                        <p>
                            {{$exam->content}}
                        </p>
                        @endif
                    </div>

                    <!-- /.box-header -->
                    <!-- form start -->
                    <form role="form" action="/exam_comments/store" method="POST" id="form-item">
                        {{csrf_field()}}
                        <input type="hidden" name="exam_id" id="exam_id" value="{{$exam->id}}">
                        <div class="box-body">

                            <div class="form-group col-sm-12">
                                <label for="user_id" class="control-label col-sm-2">选择作者<span
                                            class="required-field">*</span></label>

                                <div class="col-sm-4 col-md-4 col-lg-4">
                                    <select id="user_id" name="user_id" class="form-control select2">
                                        @foreach($users as $key => $value)
                                            <option value="{{$value->id}}"
                                                    @if($value->id == $exam_comment->user_id) selected
                                                    @endif>{{$value->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="form-group col-sm-12">
                                <label for="content" class="col-sm-2 control-label">回复<span
                                            class="required-field">*</span></label>

                                <div class="col-sm-8">
                                    <input type="hidden" value="{{$exam_comment->id or 0}}" name="id">
                                    <textarea rows="6" class="form-control" name="content" id="content"
                                              minlength="4">@if(!empty($exam_comment)){{$exam_comment->content}}@endif</textarea>
                                </div>
                            </div>

                            <div class="form-group  col-sm-12">
                                <label for="editor" class="col-sm-2 control-label">内容预览<span
                                            class="required-field">*</span></label>

                                <div class="col-sm-10 content_article">
                                    <p id="preview">
                                        @if(!empty($exam_comment) && !empty($exam_comment->content)){!! $exam_comment->content !!}@endif
                                    </p>
                                </div>
                            </div>

                        </div>
                        <!-- /.box-body -->
                        @include("layout.error")
                        <div class="box-footer" style="margin-left: 168px;">
                            <a class="btn btn-icon btn-default m-b-5"
                               href="/exam_comments?exam_id={{$exam->id}}"
                               title="取消">取消
                            </a>

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
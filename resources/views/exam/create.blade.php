@extends("layout.main")

@section("content")
    <!-- Main content -->
    <section class="content">
        <!-- Small boxes (Stat box) -->
        <div class="row">
            <div class="col-lg-10 col-xs-6">
                <div class="box box-info">
                    <div class="box-header with-border">
                        <h3 class="box-title">@if(isset($file->id))编辑真题答案@else增加真题答案@endif</h3>
                        @if(count($file)):
                        <a href="/files/create/{{$file->id}}">{{$file->filename}}</a>
                        @endif
                    </div>

                    <!-- /.box-header -->
                    <!-- form start -->
                    <form role="form" action="/exams/store" method="POST" id="form-item">
                        {{csrf_field()}}
                        <input type="hidden" name="file_id" id="file_id" value="{{$file->id}}">
                        <div class="box-body">
                            <div class="form-group col-sm-12">
                                <label for="type" class="control-label col-sm-2">选择真题类型<span
                                            class="required-field">*</span></label>

                                <div class="col-sm-4 col-md-4 col-lg-4">
                                    <select id="type" name="type" class="form-control select2">
                                        @foreach($exam_types as $key => $value)
                                            <option value="{{$key}}"
                                                    @if($key == $exam->type) selected
                                                    @endif>{{$value}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="form-group col-sm-12">
                                <label for="content" class="col-sm-2 control-label">真题<span
                                            class="required-field">*</span></label>

                                <div class="col-sm-8">
                                    <input type="hidden" value="{{$exam->id or 0}}" name="id">
                                    <textarea rows="6" class="form-control" name="content" id="content"
                                              minlength="4">@if(!empty($exam)){{$exam->content}}@endif</textarea>
                                </div>
                            </div>

                            <div class="form-group  col-sm-12">
                                <label for="editor" class="col-sm-2 control-label">内容预览<span
                                            class="required-field">*</span></label>

                                <div class="col-sm-10 content_article">
                                    <p id="preview">
                                        @if(!empty($exam) && !empty($exam->content)){!! $exam->content !!}@endif
                                    </p>
                                </div>
                            </div>

                        </div>
                        <!-- /.box-body -->
                        @include("layout.error")
                        <div class="box-footer" style="margin-left: 168px;">
                            <a class="btn btn-icon btn-default m-b-5"
                               href="/exams?file_id={{$file->id}}"
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

@section('add_script')
    <script type="text/javascript" async
            src="https://cdnjs.cloudflare.com/ajax/libs/mathjax/2.7.2/MathJax.js?config=TeX-MML-AM_CHTML">
    </script>
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
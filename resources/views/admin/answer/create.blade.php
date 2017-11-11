@extends("admin.layout.main")

@section("content")
    <!-- Main content -->
    <section class="content">
        <!-- Small boxes (Stat box) -->
        <div class="row">
            <div class="col-lg-10 col-xs-6">
                <div class="box box-info">
                    <div class="box-header with-border">
                        <h3 class="box-title">@if(isset($answer->id))编辑问题答案@else增加问题答案@endif</h3>
                        @if(count($question)):
                        <a href="/admin/questions/create/{{$question->id}}">{{$question->title}}</a>
                        @endif
                    </div>
                    <!-- /.box-header -->
                    <!-- form start -->
                    <form role="form" action="/admin/answers/store" method="POST" id="form-item">
                        {{csrf_field()}}
                        <input type="hidden" name="question_id" id="question_id" value="{{$question->id}}">
                        <div class="box-body">
                            <div class="form-group col-sm-12">
                                <label for="content" class="col-sm-2 control-label">答案<span
                                            class="required-field">*</span></label>

                                <div class="col-sm-4">
                                    <input type="hidden" value="{{$answer->id or 0}}" name="id">
                                    <textarea rows="6" class="form-control" name="content" id="content"
                                              minlength="4">@if(!empty($answer)){{$answer->content}}@endif</textarea>
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
                                                    @if($value->id == $answer->user_id) selected
                                                    @endif>{{$value->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            {{--<div class="form-group col-sm-12">--}}
                            {{--<label for="question_id" class="control-label col-sm-2">选择说说<span--}}
                            {{--class="required-field">*</span></label>--}}

                            {{--<div class="col-sm-4 col-md-4 col-lg-4">--}}
                            {{--<select id="question_id" name="question_id" class="form-control select2">--}}
                            {{--<option value="">请选择</option>--}}
                            {{--@foreach($shuoshuos as $key => $value)--}}
                            {{--<option value="{{$value->id}}"--}}
                            {{--@if($value->id == $answer->question_id) selected--}}
                            {{--@endif>{{$value->content}}</option>--}}
                            {{--@endforeach--}}
                            {{--</select>--}}
                            {{--</div>--}}
                            {{--</div>--}}

                        </div>
                        <!-- /.box-body -->
                        @include("admin.layout.error")
                        <div class="box-footer" style="margin-left: 168px;">
                            <a class="btn btn-icon btn-default m-b-5" href="/admin/answers"
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
@extends("admin.layout.main")

@section("content")
    <!-- Main content -->
    <section class="content">
        <!-- Small boxes (Stat box) -->
        <div class="row">
            <div class="col-lg-10 col-xs-6">
                <div class="box box-info">
                    <div class="box-header with-border">
                        <h3 class="box-title">@if(isset($shuoshuoComment->id))编辑说说评论@else增加说说评论@endif</h3>
                        @if(count($shuoshuo)):
                        <a href="/admin/shuoshuos/create/{{$shuoshuo->id}}">{{$shuoshuo->content}}</a>
                        @endif
                    </div>
                    <!-- /.box-header -->
                    <!-- form start -->
                    <form role="form" action="/admin/shuoshuo_comments/store" method="POST" id="form-item">
                        {{csrf_field()}}
                        <div class="box-body">
                            <input type="hidden" name="shuoshuo_id" id="shuoshuo_id" value="{{$shuoshuo->id}}">
                            <div class="form-group col-sm-12">
                                <label for="content" class="col-sm-2 control-label">说说评论名<span
                                            class="required-field">*</span></label>

                                <div class="col-sm-4">
                                    <input type="hidden" value="{{$shuoshuoComment->id or 0}}" name="id">
                                    <textarea rows="6" class="form-control" name="content" id="content"
                                              minlength="4">@if(!empty($shuoshuoComment)){{$shuoshuoComment->content}}@endif</textarea>
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
                                                    @if($value->id == $shuoshuoComment->user_id) selected
                                                    @endif>{{$value->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            {{--<div class="form-group col-sm-12">--}}
                            {{--<label for="shuoshuo_id" class="control-label col-sm-2">选择说说<span--}}
                            {{--class="required-field">*</span></label>--}}

                            {{--<div class="col-sm-4 col-md-4 col-lg-4">--}}
                            {{--<select id="shuoshuo_id" name="shuoshuo_id" class="form-control select2">--}}
                            {{--<option value="">请选择</option>--}}
                            {{--@foreach($shuoshuos as $key => $value)--}}
                            {{--<option value="{{$value->id}}"--}}
                            {{--@if($value->id == $shuoshuoComment->shuoshuo_id) selected--}}
                            {{--@endif>{{$value->content}}</option>--}}
                            {{--@endforeach--}}
                            {{--</select>--}}
                            {{--</div>--}}
                            {{--</div>--}}

                        </div>
                        <!-- /.box-body -->
                        @include("admin.layout.error")
                        <div class="box-footer" style="margin-left: 168px;">
                            <a class="btn btn-icon btn-default m-b-5" href="/admin/shuoshuo_comments"
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
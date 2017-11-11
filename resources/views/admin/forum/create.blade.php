@extends("admin.layout.main")

@section("content")
    <!-- Main content -->
    <section class="content">
        <!-- Small boxes (Stat box) -->
        <div class="row">
            <div class="col-lg-10 col-xs-6">
                <div class="box box-info">
                    <div class="box-header with-border">
                        <h3 class="box-title">@if(isset($forum->id))编辑论坛@else增加论坛@endif</h3>
                    </div>
                    <!-- /.box-header -->
                    <!-- form start -->
                    <form role="form" action="/admin/forums/store" method="POST" id="form-item">
                        {{csrf_field()}}
                        <div class="box-body">
                            <input type="hidden" value="{{$forum->id or 0}}" name="id">

                            <div class="form-group col-sm-12">
                                <label for="name" class="col-sm-2 control-label">论坛名<span
                                            class="required-field">*</span></label>

                                <div class="col-sm-4">
                                    <input type="text" class="form-control" name="name" id="name" minlength="4" required
                                           value="@if(!empty($forum)){{$forum->name}}@endif" placeholder="请输入论坛名">
                                </div>
                            </div>

                            {{--@if(isset($forum->id))--}}
                            {{--<div class="form-group col-sm-12">--}}
                            {{--<label for="alias" class="col-sm-2 control-label">论坛拼音</label>--}}

                            {{--<div class="col-sm-4">--}}
                            {{--<input type="text" class="form-control" name="alias" id="alias"--}}
                            {{--value="@if(!empty($forum)){{$forum->alias}}@endif" placeholder="请输入论坛拼音">--}}
                            {{--</div>--}}
                            {{--</div>--}}
                            {{--@endif--}}
                        </div>
                        <!-- /.box-body -->
                        @include("admin.layout.error")
                        <div class="box-footer" style="margin-left: 178px;">
                            <a class="btn btn-icon btn-default m-b-5" href="/admin/forums"
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
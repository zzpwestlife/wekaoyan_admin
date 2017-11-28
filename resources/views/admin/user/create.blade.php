@extends("admin.layout.main")

@section("content")
    <!-- Main content -->
    <section class="content">
        <!-- Small boxes (Stat box) -->
        <div class="row">
            <div class="col-lg-10 col-xs-6">
                <div class="box box-info">
                    <div class="box-header with-border">
                        <h3 class="box-title">@if(isset($user->id))编辑用户@else增加用户@endif</h3>
                    </div>
                    <!-- /.box-header -->
                    <!-- form start -->
                    <form role="form" action="/admin/users/store" method="POST" id="form-item">
                        {{csrf_field()}}
                        <input type="hidden" value="{{$user->id or 0}}" name="id">
                        {{--<div class="box-body">--}}

                        {{--<div class="form-group  col-sm-12">--}}
                        {{--<label for="content" class="col-sm-2 control-label">用户内容<span--}}
                        {{--class="required-field">*</span></label>--}}

                        {{--<div class="col-sm-4">--}}
                        {{--</div>--}}
                        {{--</div>--}}

                        {{--</div>--}}

                        <div class="form-group col-sm-12">
                            <label for="name" class="col-sm-2 control-label">用户名<span
                                        class="required-field">*</span></label>

                            <div class="col-sm-4">
                                <input type="text" class="form-control" name="name" id="name" minlength="1" required
                                       value="{{$user->name or ''}}" placeholder="请输入用户名">
                            </div>
                        </div>

                        <div class="form-group col-sm-12">
                            <label for="mobile" class="col-sm-2 control-label">手机号<span
                                        class="required-field">*</span></label>

                            <div class="col-sm-4">
                                <input type="number" class="form-control" name="mobile" id="mobile" minlength="11"
                                       maxlength="11" required
                                       value="{{$user->mobile or ''}}" placeholder="请输入手机号">
                            </div>
                        </div>

                        <div class="form-group col-sm-12">
                            <label for="qq" class="col-sm-2 control-label">QQ 号</label>

                            <div class="col-sm-4">
                                <input type="number" class="form-control" name="qq" id="qq" value="{{$user->qq or ''}}">
                            </div>
                        </div>

                        <div class="form-group col-sm-12">
                            <label for="weixin" class="col-sm-2 control-label">微信号</label>

                            <div class="col-sm-4">
                                <input type="text" class="form-control" name="weixin" id="weixin"
                                       value="{{$user->weixin or ''}}">
                            </div>
                        </div>

                        <div class="form-group col-sm-12">
                            <label for="email" class="col-sm-2 control-label">邮箱</label>

                            <div class="col-sm-4">
                                <input type="email" class="form-control" name="email" id="email"
                                       value="{{$user->email or ''}}">
                            </div>
                        </div>

                        <div class="form-group col-sm-12">
                            <label for="password" class="col-sm-2 control-label">密码</label>

                            <div class="col-sm-4">
                                @if(isset($user->id))
                                    <input type="text" class="form-control" name="password" id="password"
                                           placeholder="不修改则置空">
                                @else
                                    <input type="text" class="form-control" name="password" id="password" required>
                                @endif
                            </div>
                        </div>

                        <div class="form-group col-sm-12">
                            <label for="is_teacher" class="col-sm-2 control-label">身份</label>

                            <div class="col-sm-4">
                                <div class="form-control">
                                    <input type="radio" name="is_teacher" value="1" @if($user->is_teacher) checked @endif>
                                    老师 &emsp;
                                    <input type="radio" name="is_teacher" value="0"> 学生
                                </div>
                            </div>
                        </div>
                        <!-- /.box-body -->
                        @include("admin.layout.error")
                        <div class="box-footer" style="margin-left: 168px;">
                            <a class="btn btn-icon btn-default m-b-5" href="/admin/users"
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
@extends("admin.layout.main")

@section("content")
    <!-- Main content -->
    <section class="content">
        <!-- Small boxes (Stat box) -->
        <div class="row">
            <div class="col-lg-10 col-xs-6">
                <div class="box box-info">
                    <div class="box-header with-border">
                        <h3 class="box-title">@if(isset($major->school))编辑专业@else增加专业@endif</h3>
                    </div>
                    <!-- /.box-header -->
                    <!-- form start -->
                    <form role="form" action="/admin/majors/store" method="POST" id="form-item">
                        {{csrf_field()}}
                        <div class="box-body">
                            <input type="hidden" value="{{$major->id or 0}}" name="id">

                            <div class="form-group col-sm-12">
                                <label for="school_id" class="control-label col-sm-2">选择学校<span
                                            class="required-field">*</span></label>

                                <div class="col-sm-4 col-md-4 col-lg-4">
                                    <select id="school_id" name="school_id" class="form-control select2">
                                        <option value="">请选择</option>
                                        @foreach($schools as $key => $value)
                                            <option value="{{$value->id}}"
                                                    @if($value->id == $major->school_id) selected
                                                    @elseif($value->id == $school->id) selected
                                                    @endif>{{$value->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="form-group col-sm-12">
                                <label for="department" class="col-sm-2 control-label">学院名</label>

                                <div class="col-sm-4">
                                    <input type="text" class="form-control" name="department" id="department"
                                           value="@if(isset($major->department)){{$major->department}}@endif"
                                           placeholder="请输入学院名 可不填">
                                </div>
                            </div>

                            <div class="form-group col-sm-12">
                                <label for="name" class="col-sm-2 control-label">专业名<span
                                            class="required-field">*</span></label>

                                <div class="col-sm-4">
                                    <input type="text" class="form-control" name="name" id="name" minlength="4" required
                                           value="@if(!empty($major)){{$major->name}}@endif" placeholder="请输入专业名">
                                </div>
                            </div>
                        </div>
                        <!-- /.box-body -->
                        @include("admin.layout.error")
                        <div class="box-footer" style="margin-left: 178px;">
                            <a class="btn btn-icon btn-default m-b-5" href="/admin/majors"
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
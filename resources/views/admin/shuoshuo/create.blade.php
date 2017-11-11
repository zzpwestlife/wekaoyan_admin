@extends("admin.layout.main")

@section("content")
    <!-- Main content -->
    <section class="content">
        <!-- Small boxes (Stat box) -->
        <div class="row">
            <div class="col-lg-10 col-xs-6">
                <div class="box box-info">
                    <div class="box-header with-border">
                        <h3 class="box-title">@if(isset($shuoshuo->id))编辑说说@else增加说说@endif</h3>
                    </div>
                    <!-- /.box-header -->
                    <!-- form start -->
                    <form role="form" action="/admin/shuoshuos/store" method="POST" id="form-item">
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
                                                    @if($value->id == $shuoshuo->forum_id) selected
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
                                                    @if($value->id == $shuoshuo->user_id) selected
                                                    @endif>{{$value->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="form-group  col-sm-12">
                                <label for="content" class="col-sm-2 control-label">说说内容<span
                                            class="required-field">*</span></label>

                                <div class="col-sm-4">
                                    <input type="hidden" value="{{$shuoshuo->id or 0}}" name="id">
                                    <textarea rows="5" class="form-control" name="content" id="content" minlength="4"
                                              required>@if(!empty($shuoshuo)){{$shuoshuo->content}}@endif</textarea>
                                </div>
                            </div>

                        </div>
                        <!-- /.box-body -->
                        @include("admin.layout.error")
                        <div class="box-footer" style="margin-left: 168px;">
                            <a class="btn btn-icon btn-default m-b-5" href="/admin/shuoshuos"
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
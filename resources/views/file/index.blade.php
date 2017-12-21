@extends("layout.main")

@section('css')

    <style type="text/css">
        .table > tbody > tr > td {
            vertical-align: middle;
        }

    </style>

@endsection

@section("content")
    <div class="box">
        <div class="box-header">
            <h3 class="box-title">文件管理</h3>
            <a type="button" class="btn " href="/files/create">增加文件</a>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
            <div id="item_wrapper" class="dataTables_wrapper form-inline dt-bootstrap">
                <div class="row" id="frm_search_info" style="margin-bottom: 30px">
                    <div class="col-sm-12">
                        <div class="col-sm-4">
                            用户：
                            <select id="user_id" name="user_id" class="form-control select2">
                                <option value="0">请选择</option>
                                @foreach($users as $key => $value)
                                    <option value="{{$value->id}}" @if($value->id == $searchParams['userId']) selected
                                            @endif>{{$value->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-sm-4">
                            论坛：
                            <select id="forum_id" name="forum_id" class="form-control select2">
                                <option value="0">请选择</option>
                                @foreach($forums as $key => $value)
                                    <option value="{{$value->id}}"
                                            @if($value->id == $searchParams['forumId']) selected
                                            @endif>{{$value->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        {{--<div class="col-sm-4">--}}
                        {{--修改日期：<input type='text' class="form-control" id="start_time" name="start_time"--}}
                        {{--value="{{$searchParams['startTime']}}"--}}
                        {{--placeholder="开始时间"/>--}}

                        {{--- <input type='text' class="form-control" id="end_time" name="end_time"--}}
                        {{--value="{{$searchParams['endTime']}}"--}}
                        {{--placeholder="结束时间"/>--}}
                        {{--</div>--}}
                        <div class="col-sm-4">
                            <input type="text" name="name" id="" class="form-control" placeholder="文件名"
                                   value="{{$searchParams['name']}}">
                            <button name="" id="btn_clear" class="btn btn-default" type="submit">
                                清空
                            </button>
                            <button name="" id="btn_search" class="btn btn-success" type="submit">
                                搜索
                            </button>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12">
                        <table id="item-table" class="table table-bordered table-hover dataTable" role="grid"
                               aria-describedby="item_info">
                            <thead>
                            <tr role="row">
                                <th style="width: 10px">#</th>
                                <th>文件名</th>
                                <th>上传者</th>
                                <th>所属论坛</th>
                                {{--<th>分类</th>--}}
                                <th>资料类型</th>
                                {{--<th>文件状态</th>--}}
                                <th>下载量</th>
                                {{--<th>添加时间</th>--}}
                                {{--<th>修改时间</th>--}}
                                <th>操作</th>
                            </tr>
                            </thead>
                            <tbody>


                            @if (count($files) > 0)
                                @foreach($files as $item)
                                    <tr>
                                        <td width="6%">{{$item->id}}</td>
                                        <td>{{$item->filename}}</td>
                                        <td>@if(isset($item->user)){{$item->user->name}}@else未知@endif</td>
                                        <td>@if(isset($item->forum)){{$item->forum->name}}@else未知@endif</td>
                                        <td>@if($item->type==1)资料@else真题@endif</td>
                                        {{--<td>@if($item->status==1)有效@else无效@endif</td>--}}
                                        <td>{{$item->downloads}}</td>
                                        {{--<td>{{$item->created_at->diffForHumans()}}</td>--}}
                                        {{--<td>{{$item->updated_at->diffForHumans()}}</td>--}}
                                        <td>
                                            <a class="btn btn-icon btn-default" data-toggle="tooltip"
                                               href="{{"/files/create/".$item->id}}"
                                               title="编辑">
                                                <i class="fa fa-edit"></i>
                                            </a>

                                            @if(isset($item) && !empty($item->uri))
                                                <a class="btn btn-icon btn-success" data-toggle="tooltip"
                                                   href="{{DATA_URL . $item->uri}}" target="_blank"
                                                   title="下载">
                                                    <i class="fa fa-download"></i>
                                                </a>
                                            @endif

                                            <a class="btn btn-icon btn-danger btn-delete"
                                               data-toggle="tooltip"
                                               href="javascript:;" title="删除" data-operate-type="delete"
                                               data-item-id="{{$item->id}}"
                                               data-item-filename="{{$item->filename}}">
                                                <i class="fa fa-trash"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="20">
                                        <div class="alert alert-warning" role="alert" style="text-align: center;">
                                            无相关信息
                                        </div>
                                    </td>
                                </tr>
                            @endif
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="row">
                    {{--<div class="col-sm-4 dataTables_info">--}}
                    {{--显示第1-20行，共444行--}}
                    {{--</div>--}}
                    <div class="col-sm-12">
                        {{$files->appends($searchParams)->links()}}
                    </div>
                </div>
            </div>
        </div>
        @endsection

        @section('script')
            <script type="text/javascript">

                $(document).ready(function () {

                    $(".select2").select2({language: "zh-CN"});
                    // 搜索
                    searchWithParams('/files/?page=1');

                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });

                    $('.btn-delete').click(function () {
                        var itemId = $(this).attr("data-item-id");
                        var itemName = $(this).attr("data-item-filename");
                        if (window.confirm('你确定要删除 ' + itemName + ' 吗？')) {
                            $.ajax({
                                type: "POST",
                                url: "/files/delete",
                                data: {id: itemId},
                                dataType: "JSON",
                                success: function (data) {
                                    console.log(data);
                                    if (!0 == data.error) {
                                        return false;
                                    }
                                }
                            });
                            location.reload();
                        } else {
                            return false;
                        }
                    });

                    return false;
                });

            </script>
@endsection
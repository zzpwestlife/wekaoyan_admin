@extends("admin.layout.main")

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
            <h3 class="box-title">用户管理</h3>
            <a type="button" class="btn" href="{{"/admin/users/create"}}">增加用户</a>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
            <div id="item_wrapper" class="dataTables_wrapper form-inline dt-bootstrap">
                <div class="row">
                    <div class="col-sm-6"></div>
                    <div class="col-sm-6"></div>
                </div>
                <div class="row">
                    <div class="col-sm-12">
                        <table id="item-table" class="table table-bordered table-hover dataTable" role="grid"
                               aria-describedby="item_info">
                            <thead>
                            <tr role="row">
                                <th style="width: 10px">#</th>
                                <th>用户名</th>
                                {{--<th>密码</th>--}}
                                <th>手机号</th>
                                <th>QQ</th>
                                <th>微信</th>
                                <th>邮箱</th>
                                {{--<th>头像</th>--}}
                                <th>身份</th>
                                <th>添加时间</th>
                                <th>修改时间</th>
                                <th>操作</th>
                            </tr>
                            </thead>
                            <tbody>


                            @if (count($users) > 0)
                                @foreach($users as $item)
                                    <tr>
                                        <td>{{$item->id}}</td>
                                        <td>{{$item->name}}</td>
                                        <td>{{$item->mobile}}</td>
                                        <td>{{$item->qq}}</td>
                                        <td>{{$item->weixin}}</td>
                                        <td>{{$item->email}}</td>
                                        {{--<td><img src="{{$item->url}}" alt=""></td>--}}
                                        <td>@if($item->is_teacher)老师@else学生@endif</td>
                                        <td>{{$item->created_at->diffForHumans()}}</td>
                                        <td>{{$item->updated_at->diffForHumans()}}</td>
                                        <td>
                                            <a class="btn btn-icon btn-default" data-toggle="tooltip"
                                               href="{{"/admin/users/create/".$item->id}}"
                                               title="编辑">
                                                <i class="fa fa-edit"></i>
                                            </a>

                                            <a class="btn btn-icon btn-danger btn-delete"
                                               data-toggle="tooltip"
                                               href="javascript:;" title="删除" data-operate-type="delete"
                                               data-item-id="{{$item->id}}" data-item-content="{{$item->content}}">
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
                        {{$users->links()}}
                    </div>
                </div>
            </div>
        </div>
        @endsection

        @section('script')
            <script type="text/javascript">

                $(document).ready(function () {

                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });

                    $('.btn-delete').click(function () {
                        var itemId = $(this).attr("data-item-id");
                        var itemName = $(this).attr("data-item-content");
                        if (window.confirm('你确定要删除 ' + itemName + ' 吗？')) {
                            $.ajax({
                                type: "POST",
                                url: "/admin/users/delete",
                                data: {id: itemId},
                                dataType: "JSON",
                                success: function (data) {
                                    console.log(data);
                                    if (0 != data.error) {
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
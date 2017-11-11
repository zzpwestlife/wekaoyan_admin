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
            <h3 class="box-title">学校管理</h3>
            <a type="button" class="btn " href="/admin/schools/create">增加学校</a>
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
                                <th>学校名</th>
                                <th>添加时间</th>
                                <th>修改时间</th>
                                <th>操作</th>
                            </tr>
                            </thead>
                            <tbody>


                            @if (count($schools) > 0)
                                @foreach($schools as $item)
                                    <tr>
                                        <td width="6%">{{$item->id}}</td>
                                        <td>{{$item->name}}</td>
                                        <td>{{$item->created_at->diffForHumans()}}</td>
                                        <td>{{$item->updated_at->diffForHumans()}}</td>
                                        <td>
                                            <a class="btn btn-icon btn-default" data-toggle="tooltip"
                                               href="{{"/admin/schools/create/".$item->id}}"
                                               title="编辑">
                                                <i class="fa fa-edit"></i>
                                            </a>

                                            @if ($item->major_count > 0)
                                                <a class="btn btn-icon btn-info"
                                                   data-toggle="tooltip"
                                                   href="{{"/admin/majors?school_id=".$item->id}}"
                                                   title="学院专业管理">
                                                    <i class="fa fa-list-ol"></i>
                                                </a>
                                            @else
                                                <a class="btn btn-icon btn-danger btn-delete"
                                                   data-toggle="tooltip"
                                                   href="javascript:;" title="删除" data-operate-type="delete"
                                                   data-item-id="{{$item->id}}" data-item-name="{{$item->name}}">
                                                    <i class="fa fa-trash"></i>
                                                </a>
                                            @endif
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
                        {{$schools->links()}}
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
                        var itemName = $(this).attr("data-item-name");
                        if (window.confirm('你确定要删除 ' + itemName + ' 吗？')) {
                            $.ajax({
                                type: "POST",
                                url: "/admin/schools/" + itemId + '/delete',
                                dataType: "JSON",
                                success: function (data) {
                                    console.log(data);
                                    if (!0 != data.error) {
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
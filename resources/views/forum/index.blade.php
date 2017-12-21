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
            <h3 class="box-title">论坛管理</h3>
            <a type="button" class="btn" href="{{"/forums/create"}}">增加论坛</a>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
            <div id="item_wrapper" class="dataTables_wrapper form-inline dt-bootstrap">
                <div class="row" id="frm_search_info" style="margin-bottom: 30px">
                    <div class="col-sm-12">
                        <div class="col-sm-5">
                            修改日期：<input type='text' class="form-control" id="start_time" name="start_time"
                                        value="{{$searchParams['startTime']}}"
                                        placeholder="开始时间"/>

                            - <input type='text' class="form-control" id="end_time" name="end_time"
                                     value="{{$searchParams['endTime']}}"
                                     placeholder="结束时间"/>
                        </div>
                        <div class="col-sm-6">
                            <input type="text" name="name" id="" class="form-control" placeholder="论坛名/拼音/缩写"
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
                                <th>论坛名</th>
                                <th>拼音</th>
                                <th>拼音缩写</th>
                                <th>添加时间</th>
                                <th>修改时间</th>
                                <th>操作</th>
                            </tr>
                            </thead>
                            <tbody>

                            @if (count($forums) > 0)
                                @foreach($forums as $item)
                                    <tr>
                                        <td width="6%">{{$item->id}}</td>
                                        <td>{{$item->name}}</td>
                                        <td>{{$item->alias}}</td>
                                        <td>{{$item->alias_abbr}}</td>
                                        <td>{{$item->created_at->diffForHumans()}}</td>
                                        <td>{{$item->updated_at->diffForHumans()}}</td>
                                        <td>
                                            <a class="btn btn-icon btn-default" data-toggle="tooltip"
                                               href="{{"/forums/create/".$item->id}}"
                                               title="编辑">
                                                <i class="fa fa-edit"></i>
                                            </a>

                                            <a class="btn btn-icon btn-danger btn-delete"
                                               data-toggle="tooltip"
                                               href="javascript:;" title="删除" data-operate-type="delete"
                                               data-item-id="{{$item->id}}" data-item-name="{{$item->name}}">
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
                        {{$forums->appends($searchParams)->links()}}
                    </div>
                </div>
            </div>
        </div>
        @endsection

        @section('script')
            <script type="text/javascript">

                $(document).ready(function () {
                    $.datetimepicker.setLocale('zh');
                    $('#start_time, #end_time').datetimepicker({
                        'step': 1,
                        maxDate: '+1970/01/02'//tomorrow is maximum date calendar
                    });

                    // 搜索
                    searchWithParams('/forums/?page=1');

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
                                url: "/forums/delete",
                                data: {id: itemId},
                                dataType: "JSON",
                                success: function (data) {
                                    console.log(data);
                                    if (0 != data.error) {
                                        return false;
                                    }
                                },
                                error: function (error) {
                                    console.log(error);
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
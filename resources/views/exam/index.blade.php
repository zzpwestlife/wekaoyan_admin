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
                <h3 class="box-title">
                    真题管理
                    @if(count($file)):
                    <a href="/questions/create/{{$file->id}}">{{$file->filename}}</a>
                    <a type="button" class="btn"
                       href="{{"/exams/create?file_id=".$file->id}}">增加真题</a>
                    @endif
                </h3>

            </div>
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
                                    <th>真题</th>
                                    <th>添加时间</th>
                                    <th>修改时间</th>
                                    <th>操作</th>
                                </tr>
                                </thead>
                                <tbody>


                                @if (count($exams) > 0)
                                    @foreach($exams as $item)
                                        <tr>
                                            <td width="6%">{{$item->id}}</td>
                                            <td>{{$item->content}}</td>
                                            <td>{{$item->created_at->diffForHumans()}}</td>
                                            <td>{{$item->updated_at->diffForHumans()}}</td>
                                            <td>
                                                <a class="btn btn-icon btn-default" data-toggle="tooltip"
                                                   href="{{"/exams/create/".$item->id.'?file_id='.$file->id}}"
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
                                    url: "/exam/delete",
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
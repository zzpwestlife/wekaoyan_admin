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
            <h3 class="box-title">
                问题答案管理
                @if(count($question)):
                <a href="/admin/questions/create/{{$question->id}}">{{$question->title}}</a>
                <a type="button" class="btn"
                   href="{{"/admin/answers/create?question_id=".$question->id}}">增加问题答案</a>
                @endif
            </h3>

        </div>
        <!-- /.box-header -->
        <div class="box-body">
            <div id="item_wrapper" class="dataTables_wrapper form-ineÏ                  aria-describedby="item_info">
                            <thead>
                            <tr role="row">
                                <th style="width: 10px">#</th>
                                <th>发表用户</th>
                                <th>评论内容</th>
                                <th>添加时间</th>
                                <th>修改时间</th>
                                <th>操作</th>
                            </tr>
                            </thead>
                            <tbody>


                            @if (count($answers) > 0)
                                @foreach($answers as $item)
                                    <tr>
                                        <td width="6%">{{$item->id}}</td>
                                        <td width="8%">@if(isset($item->user)){{$item->user->name}}@endif</td>
                                        <td style="width: 50%">{{$item->content}}</td>
                                        <td width="12%">{{$item->created_at->diffForHumans()}}</td>
                                        <td width="12%">{{$item->updated_at->diffForHumans()}}</td>
                                        <td width="12%">
                                            <a class="btn btn-icon btn-default" data-toggle="tooltip"
                                               href="{{"/admin/answers/create/".$item->id.'?question_id='.$question->id}}"
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
                        {{$answers->links()}}
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
                                url: "/admin/answers/delete",
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
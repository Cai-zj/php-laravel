@extends('admin.master')
@section('content')
    <nav class="breadcrumb"><i class="Hui-iconfont">&#xe67f;</i> 首页 <span class="c-gray en">&gt;</span> 用户中心 <span class="c-gray en">&gt;</span> 用户管理 <a class="btn btn-success radius r" style="line-height:1.6em;margin-top:3px" href="javascript:location.replace(location.href);" title="刷新" ><i class="Hui-iconfont">&#xe68f;</i></a></nav>
    <div class="page-container">

        <div class="cl pd-5 bg-1 bk-gray mt-20">
            <span class="l">
                <a href="javascript:;" onclick="admin_add('添加用户','/as/admin_add')" class="btn btn-primary radius">
                    <i class="Hui-iconfont">&#xe600;</i> 添加用户
                </a>
            </span> <span class="r">共有数据：<strong>{{count($admins)}}</strong> 条</span> </div>
        <div class="mt-20">
            <table class="table table-border table-bordered table-hover table-bg table-sort">
                <thead>
                <tr class="text-c">
                    <th width="25"><input type="checkbox" name="" value=""></th>
                    <th width="80">ID</th>
                    <th width="80">姓名</th>
                    <th width="100">用户名</th>
                    <th width="150">邮箱</th>
                    <th width="50">地址</th>
                    <th width="130">加入时间</th>
                    <th width="70">状态</th>
                    <th width="100">操作</th>
                </tr>
                </thead>
                <tbody>
                @foreach($admins as $admin)
                <tr class="text-c">
                    <td><input type="checkbox" value="1" name=""></td>
                    <td>{{$admin->id}}</td>
                    <td>{{$admin->nikename}}</td>
                    <td><u style="cursor:pointer" class="text-primary"></u>{{$admin->username}}</td>
                    <td>{{$admin->email}}</td>
                    <td>{{$admin->address}}</td>
                    <td>{{$admin->created_at}}</td>
                    <td class="td-status"><span class="label label-success radius">@if($admin->is_delete===0)已启用 @else 已禁用 @endif</span></td>
                    <td class="td-manage">
                        <a style="text-decoration:none" onClick="admin_stop(this,'{{$admin->id}}')" href="javascript:;" title="停用"><i class="Hui-iconfont">&#xe631;</i></a>
                        <a style="text-decoration:none" class="ml-5" onClick="admin_edit('修改密码','/as/admin_edit/{{$admin->id}}')" href="javascript:;" title="修改密码"><i class="Hui-iconfont">&#xe63f;</i></a> </td>
                </tr>
                @endforeach
                </tbody>`
            </table>
        </div>
    </div>
@endsection

@section('my-js')
    <script type="text/javascript">
        function admin_add(title,url) {
//            layer_show(name, url,w,r); 这里是弹出对话宽,指定宽度,高度
            var index = layer.open({
                type: 2,
                title: title,
                content: url
            });
            layer.full(index);
        }
        function admin_edit(title,url) {
//            layer_show(name, url,w,r); 这里是弹出对话宽,指定宽度,高度
            var index = layer.open({
                type: 2,
                title: title,
                content: url
            });
            layer.full(index);
        }
        /*管理员-停用*/
        function admin_stop(obj,id){
            layer.confirm('确认要停用吗？',function(index){

                $.ajax({
                    type: 'POST',
                    url: '/as/admin/stop',
                    dataType: 'json',
                    data:{
                      id : id,
                      _token : "{{csrf_token()}}",
                    },
                    success: function(data){
                        $(obj).parents("tr").remove();
                        layer.msg('已停用!',{icon:1,time:1000});
                    },
                    error:function(data) {
                        console.log(data.msg);
                    },
                });

                //此处请求后台程序，下方是成功后的前台处理……
                $(obj).parents("tr").find(".td-manage").prepend('<a onClick="admin_start(this,id)" href="javascript:;" title="启用" style="text-decoration:none"><i class="Hui-iconfont">&#xe615;</i></a>');
                $(obj).parents("tr").find(".td-status").html('<span class="label label-default radius">已禁用</span>');
                $(obj).remove();
                layer.msg('已停用!',{icon: 5,time:1000});
            });
        }

    </script>
@endsection
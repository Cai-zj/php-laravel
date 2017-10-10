@extends('admin.master')
<style>
    ul.pagination {
        padding: 0;
        margin: 0;
        color: black;
        float: left;
        padding: 8px 16px;
        text-decoration: none;
    }

    ul.pagination li {
        color: black;
        float: left;
        padding: -1px 16px;
        text-decoration: none;
    }
    li.active{
        color: black;
        float: left;
        padding: 8px 16px;
        text-decoration: none;
    }

    ul.pagination li a {
        color: black;
        float: left;
        padding: 8px 16px;
        text-decoration: none;
    }
    ul.pagination li a:hover:not(.active) {background-color: #ddd;}
    ul.pagination li a {
        border: 1px solid #ddd; /* Gray */
    }
</style>

@section('content')
    <div class="pd-20">
        <div class="cl pd-5 bg-1 bk-gray mt-20">
        <span class="l">
  			<a href="javascript:;" onclick="content_add('添加文章','/as/article_add')" class="btn btn-primary radius">
                <i class="Hui-iconfont">&#xe600;</i> 添加文章</a>
        </span>
            <span class="r">共有数据：<strong>{{count($articles)}}</strong> 条</span>
        </div>
    </div>
    <div class="mt-20">
        <table class="table table-border table-bordered table-hover table-bg table-sort"  style="table-layout:fixed;" >
            <thead>
            <tr class="text-c">
                <th width="50">ID</th>
                <th width="300">文章标题</th>
                <th width="400">内容详情</th>
                <th width="50">点击数</th>
                <th width="50">浏览数</th>
                <th width="50">来源</th>
                <th width="200">封面图</th>
            </tr>
            </thead>
            <tbody style="width: 100px;table-layout: fixed;">
            @foreach($articles as $article)
                <tr class="text-c">
                    <td>{{$article->id}}</td>
                    <td>{{$article->title}}</td>
                    <td style="overflow:hidden;text-overflow:ellipsis;word-break:keep-all;white-space:nowrap;">{{$article->detail}}</td>
                    <td>{{$article->like_count}}</td>
                    <td>{{$article->view_count}}</td>
                    <td>{{$article->source}}</td>
                    <td><img src="{{$article->cover}}" width="200" height="100"></td>
                    <td class="td-manage">
                        <a title="编辑" href="javascript:;" onclick="content_edit('编辑','/as/article_edit/?id={{$article->id}}')" class="ml-5" style="text-decoration:none"><i class="Hui-iconfont">&#xe6df;</i></a>
                        <a title="删除" href="javascript:;" onclick="content_del('{{$article->title}}', '{{$article->id}}')" class="ml-5" style="text-decoration:none"><i class="Hui-iconfont">&#xe6e2;</i></a>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
    <div class="page_list" >
        {!! with(new \App\Tool\Pagination\CustomerPresenter($articles))->render() !!}
    </div>
@endsection
@section('my-js')
    <script type="text/javascript">

        function content_add(title,url) {
            var index = layer.open({
                type: 2,
                title: title,
                content: url
            });
            layer.full(index);
        }
        function content_edit(title,url) {
            var index = layer.open({
                type: 2,
                title: title,
                content: url
            });
            layer.full(index);
        }

        function content_del(name, id) {
            layer.confirm('确认要删除【' + name +'】吗？',function(index){
                //此处请求后台程序，下方是成功后的前台处理……
                $.ajax({
                    type: 'post', // 提交方式 get/post
                    url: '/as/article/del', // 需要提交的 url
                    dataType: 'json',
                    data: {
                        id: id,
                        _token: "{{csrf_token()}}"
                    },
                    success: function(data) {
                        if(data == null) {
                            layer.msg('服务端错误', {icon:2, time:2000});
                            return;
                        }
                        if(data.state != 0) {
                            layer.msg(data.message, {icon:2, time:2000});
                            return;
                        }

                        layer.msg(data.message, {icon:1, time:2000});
                        location.replace(location.href);
                    },
                    error: function(xhr, status, error) {
                        console.log(xhr);
                        console.log(status);
                        console.log(error);
                        layer.msg('ajax error', {icon:2, time:2000});
                    },
                    beforeSend: function(xhr){
                        layer.load(0, {shade: false});
                    }
                });
            });
        }

    </script>
@endsection

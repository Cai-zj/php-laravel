@extends('admin.master')
@section('content')
    <form action="" method="post" class="form form-horizontal" id="form-content-add">
        {{ csrf_field() }}
        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>文章标题：</label>
            <div class="formControls col-xs-8 col-sm-3">
                <input type="text" class="input-text" value="{{$article->title}}" placeholder="" name="title" datatype="*" nullmsg="标题不能为空">
            </div>
            <div class="col-4"> </div>
        </div>
        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-3"></span>来源：</label>
            <div class="formControls col-xs-8 col-sm-3">
                <input type="text" class="input-text" value="{{$article->source}}" placeholder="" name="source">
            </div>
            <div class="col-4"> </div>
        </div>
        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-3"></span>点击数：</label>
            <div class="formControls col-xs-8 col-sm-3">
                <input type="text" class="input-text" value="{{$article->like_count}}" placeholder="" name="like_count"   >
            </div>
            <div class="col-4"> </div>
        </div>
        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-3"></span>浏览数：</label>
            <div class="formControls col-xs-8 col-sm-3">
                <input type="text" class="input-text" value="{{$article->view_count}}" placeholder="" name="view_count"   >
            </div>
            <div class="col-4"> </div>
        </div>
        <div class="row cl">
            <label class="form-label col-xs-3 col-3">封面图：</label>
            <div class="formControls col-xs-8 col-sm-3">
                @if($article->cover !=null)
                    <img id="preview_id" src="{{$article->cover}}" style="border: 1px solid #B8B9B9; width: 350px; height: 150px; " onclick="$('#input_id').click()" />
                @else
                    <img id="preview_id" src="/static/h-ui.admin/images/icon-add.png" style="border: 1px solid #B8B9B9; width:350px; height: 150px; " onclick="$('#input_id').click()" />
                @endif
                <input type="file" name="file" id="input_id" style="display: none;" onchange="return uploadImageToServer('input_id','images', 'preview_id');" />
            </div>
        </div>
        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-3">内容详情：</label>
            <div class="formControls col-xs-8 col-sm-6">
                <script id="editor" type="text/plain" style="width:100%; height:400px;">{!!$article->detail!!}</script>
            </div>
        </div>

        <div class="row cl">
            <div class="col-9 col-offset-3">
                <input style="margin: 20px 0; width: 200px;" class="btn btn-primary radius" type="submit" value="&nbsp;&nbsp;提交&nbsp;&nbsp;">
            </div>
        </div>
    </form>

@endsection
@section('my-js')
    <script type="text/javascript">
        var ue = UE.getEditor('editor',{rgb2Hex: true});
        ue.execCommand( "getlocaldata" );

        $("#form-content-add").Validform({
            tiptype:2,
            callback:function(form){
                $('#form-content-add').ajaxSubmit({
                    type: 'post',
                    url: '/as/article/edit',
                    dataType: 'json',
                    data: {
                        id:'{{$article->id}}',
                        title: $('input[name=title]').val(),
                        like_count:$('input[name=like_count]').val(),
                        view_count: $('input[name=view_count]').val(),
                        source: $('input[name=source]').val(),
                        cover: ($('#preview_id').attr('src')!='/admin/images/icon-add.png'?$('#preview_id').attr('src'):''),
                        detail: ue.getContent(),
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
                        parent.location.reload();
                    },
                    error: function(xhr, status, error) {
                        console.log(xhr);
                        console.log(status);
                        console.log(error);
                        layer.msg('ajax error', {icon:2, time:2000});
                    },
                    beforeSend: function(xhr){
                        layer.load(0, {shade: false});
                    },
                });

                return false;
            }
        });

    </script>
@endsection
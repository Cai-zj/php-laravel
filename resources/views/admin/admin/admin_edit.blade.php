@extends('admin.master')
@section('content')
    <article class="page-container">
        <form class="form form-horizontal" id="form-admin-edit" method="post">
           <div class="row cl">
                  <label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>初始密码：</label>
                  <div class="formControls col-xs-8 col-sm-3">
                      <input type="password" class="input-text" autocomplete="off" value="" id="old_password" placeholder="密码" name="old_password">
                      <input type="hidden" value="{{$id}}" name ="id" id ="id">
                  </div>
           </div>
            <div class="row cl">
                <label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>修改密码：</label>
                <div class="formControls col-xs-8 col-sm-3">
                    <input type="password" class="input-text" autocomplete="off" value="" id="password" placeholder="密码" name="password">
                </div>
            </div>
            <div class="row cl">
                <label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>确认密码：</label>
                <div class="formControls col-xs-8 col-sm-3">
                    <input type="password" class="input-text" autocomplete="off"  id="password2" placeholder="确认新密码" name="password2">
                </div>
            </div>
            <div class="row cl">
                <div class="col-xs-8 col-sm-9 col-xs-offset-4 col-sm-offset-3">
                    <input class="btn btn-primary radius" type="submit" value="&nbsp;&nbsp;提交&nbsp;&nbsp;">
                </div>
            </div>
        </form>
    </article>
@endsection
@section('my-js')
    <script type="text/javascript">

            $("#form-admin-edit").Validform({
                tiptype:2,
                callback:function(form){

                    $('#form-admin-edit').ajaxSubmit({
                        type: 'post', // 提交方式 get/post
                        url: '/as/admin/edit', // 需要提交的 url
                        dataType: 'json',
                        data: {
                            id: "{{$id}}",
                            old_password: $('input[name=old_password]').val(),
                            password: $('input[name=password]').val(),
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
@extends('admin.master')
@section('content')
    <article class="page-container">
        <form class="form form-horizontal" id="form-admin-add" method="post">
            <div class="row cl">
                <label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>管理员(登录账号)：</label>
                <div class="formControls col-xs-8 col-sm-3">
                    <input type="text" class="input-text" value="" placeholder=""  id="username" name="username">
                </div>
            </div>
            <div class="row cl">
                <label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>用户姓名：</label>
                <div class="formControls col-xs-8 col-sm-3">
                    <input type="text" class="input-text" value="" placeholder=""  id="nikename" name="nikename">
                    <input type="hidden" name="_token" value="{{csrf_token()}}">
                </div>
            </div>
            <div class="row cl">
                <label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>初始密码：</label>
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
                <label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>地址：</label>
                <div class="formControls col-xs-8 col-sm-3">
                    <input type="text" class="input-text" placeholder="地址" name="address" id="address">
                </div>
            </div>
            <div class="row cl">
                <label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>邮箱：</label>
                <div class="formControls col-xs-8 col-sm-3">
                    <input type="text" class="input-text" placeholder="@" name="email" id="email">
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

        $(function(){
            $('.skin-minimal input').iCheck({
                checkboxClass: 'icheckbox-blue',
                radioClass: 'iradio-blue',
                increaseArea: '20%'
            });
        $_toke = "{{csrf_token()}}";
            $("#form-admin-add").validate({
                rules:{
                    username:{
                        required:true,
                        minlength:4,
                        maxlength:16
                    },
                    password:{
                        required:true,
                    },
                    password2:{
                        required:true,
                        equalTo: "#password"
                    },
                    nikename:{
                        required:true,
                    },
                    address:{
                        required:true,
                    },
                    email:{
                        required:true,
                        email:true,
                    },
                    _token: {
                        required:true,
                        _token: $_toke,
                    },
                },
                onkeyup:false,
                focusCleanup:true,
                success:"valid",
                submitHandler:function(form){
                    $(form).ajaxSubmit({
                        type: 'post',
                        url: "/as/admin/add" ,
                        success: function(data){
                            layer.msg('添加成功!',{icon:1,time:1000});
                        },
                        error: function(XmlHttpRequest, textStatus, errorThrown){
                            layer.msg('error!',{icon:1,time:1000});
                        }
                    });
                    //$(form).ajaxSubmit();
                    var index = parent.layer.getFrameIndex(window.name);
                    //parent.$('.btn-refresh').click();
                    parent.layer.close(index);
                }
            });
        });

    </script>
@endsection
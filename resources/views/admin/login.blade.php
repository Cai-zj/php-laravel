@extends('admin.master')
@section('content')
<link href="/static/h-ui.admin/css/H-ui.login.css" rel="stylesheet" type="text/css" />

<input type="hidden" id="TenantId" name="TenantId" value="" />
<div class="header"></div>
<div class="loginWraper">
    <div id="loginform" class="loginBox">
        <div class="form form-horizontal"  >
            <div class="row cl">
                <label class="form-label col-xs-3"><i class="Hui-iconfont">&#xe60d;</i></label>
                <div class="formControls col-xs-8">
                    <input id="" name="username" type="text" placeholder="用户名" class="input-text size-L">
                </div>
            </div>
            <div class="row cl">
                <label class="form-label col-xs-3"><i class="Hui-iconfont">&#xe60e;</i></label>
                <div class="formControls col-xs-8">
                    <input id="" name="password" type="password" placeholder="密码" class="input-text size-L">
                </div>
            </div>
            <div class="row cl">
                <div class="formControls col-xs-8 col-xs-offset-3">
                    <input class="input-text size-L" name="validate_code" type="text" placeholder="验证码" onblur="if(this.value==''){this.value='验证码:'}" onclick="if(this.value=='验证码:'){this.value='';}" value="" style="width:150px;">
                    <img src="/auth/validate_code/create" class="bk_validate_code" ><p>看不清,点击图片换一张</p> </div>

            </div>
            <div class="row cl">
                <div class="formControls col-xs-8 col-xs-offset-3">
                    <button  type="button" onclick="loginClick();"  class="btn btn-success radius size-L" >登录</button>
                    <!--这里是提示表单验证部分 -->
                    <div class="bk_toptips"><span class="col-xs-offset-3"></span></div>
                </div>
            </div>
        </div>
    </div>

</div>
<div class="footer">Copyright ***有限公司  </div>
@endsection
@section('my-js')
    <script type="text/javascript">

        //刷新验证码
        $('.bk_validate_code').click(function () {
            $(this).attr('src', '/auth/validate_code/create?random=' + Math.random());
        });

        //登录验证
        function loginClick() {

            var username = $('input[name=username]').val();
            var password = $('input[name=password]').val();
            var validate_code = $('input[name=validate_code]').val();

            if (validate(username, password, validate_code)==false) {
                return ;
            }
            $.ajax({
                type: "POST",
                url: '/as/goLogin',
                dataType: 'json',
                cache: false,
                data: {
                    username: username,
                    password: password,
                    validate_code: validate_code,
                    _token: "{{csrf_token()}}",
                },
                success: function (data) {
                    if (data == null) {
                        $('.bk_validate_code').attr('src', '/auth/validate_code/create?random=' + Math.random());
                        $('.bk_toptips').show();
                        $('.bk_toptips span').html('服务端错误');

                        setTimeout(function () {
                            $('.bk_toptips').hide();
                        }, 2000);
                        return;
                    }
                    if (data.state != 0) {

                        $('.bk_validate_code').attr('src', '/auth/validate_code/create?random=' + Math.random());
                        $('.bk_toptips').show();
                        $('.bk_toptips span').html(data.message);

                        setTimeout(function () {
                            $('.bk_toptips').hide();
                        }, 2000);
                        return;
                    }
                    $('.bk_validate_code').attr('src', '/auth/validate_code/create?random=' + Math.random());

                    $('.bk_toptips').show();
                    $('.bk_toptips span').html('');

                    setTimeout(function () {
                        $('.bk_toptips').hide();
                    }, 2000);
                    location.href = "/as/index";
                },
                error: function (xhr, status, error) {

                    $('.bk_validate_code').attr('src', '/auth/validate_code/create?random=' + Math.random());
                    console.log(xhr);
                    console.log(status);
                    console.log(error);
                }
            });

            function validate(username,password,validate_code) {
                if(username == '') {
                    $('.bk_toptips').show();
                    $('.bk_toptips span').html('请输入用户名');
                    setTimeout(function() {$('.bk_toptips').hide();}, 2000);
                    return false;
                }
                if(password == '') {
                    $('.bk_toptips').show();
                    $('.bk_toptips span').html('请输入密码');
                    setTimeout(function() {$('.bk_toptips').hide();}, 2000);
                    return false;
                }
                if(validate_code == '') {
                    $('.bk_toptips').show();
                    $('.bk_toptips span').html('请输入验证码');
                    setTimeout(function() {$('.bk_toptips').hide();}, 2000);
                    return false;
                }

            }
        }
    </script>
@endsection
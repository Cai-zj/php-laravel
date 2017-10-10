<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', 'Article\ArticlesController@article');


//获取验证码
Route::any('/auth/validate_code/create', 'Auth\ValidateController@create');

//后台管理
Route::group(['prefix'=>'as'], function () {

//    Route::get("/add",function () {
//        $admin = new App\Entity\Admin();
//        $admin->nikename = "admin_name";
//        $admin->username = "admin";
//        $admin->password = md5('xx_oo_pp_'."admin");
//        $admin->address = "广州";
//        $admin->save();
//    });

    //登录页面
    Route::get('/login','Admin\AdminController@toLogin');
    Route::get('/exit', 'Admin\AdminController@toExit');
    Route::post('/goLogin', 'Admin\AdminController@login');

    Route::group(['middleware'=>'check.admin.login'], function () {
        //共用上传图片
        Route::post('upload/{type}', 'Admin\UploadController@uploadFile');
        //欢迎页
        Route::get('/welcome', 'Admin\AdminController@welcome');
        //首页
        Route::get('/index','Admin\AdminController@toIndex');
        //管理员
        Route::get('/admins', 'Admin\AdminController@adminList');
        Route::get('/admin_add','Admin\AdminController@toAdminAdd');
        Route::post('/admin/add', 'Admin\AdminController@adminAdd');
        Route::get('/admin_edit/{id}', 'Admin\AdminController@toAdminEdit');
        Route::post('/admin/edit', 'Admin\AdminController@adminEdit');
        Route::post('/admin/stop', 'Admin\AdminController@adminStop');
        //文章管理
        Route::get('/article', 'Admin\ArticleController@articleList');
        Route::get('/article_add', 'Admin\ArticleController@toArticleAdd');
        Route::post('/article/add', 'Admin\ArticleController@articleAdd');
        Route::get('/article_edit', 'Admin\ArticleController@toArticleEdit');
        Route::post('/article/edit', 'Admin\ArticleController@articleEdit');
        Route::post('/article/del', 'Admin\ArticleController@articleDel');
    });
});
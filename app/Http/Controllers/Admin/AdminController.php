<?php
/**
 * Created by IntelliJ IDEA.
 * User: caizhuojie
 * Date: 2017/8/10
 * Time: 14:26
 */

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\MessageResult;
use App\Entity\Admin;


class AdminController extends Controller
{

    //********************************View*******************************************//
    /**
     * 登录页面
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function toLogin()
    {
        return view('admin.login');
    }



    /**
     * 欢迎界面
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function welcome()
    {
        return view('admin.welcome');
    }


    /**
     * 后台首页
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function toIndex(Request $request)
    {
        $admin = $request->session()->get('admin');
        return view('admin.index')->with('admin', $admin);
    }

    /**
     * 退出登录
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function toExit(Request $request)
    {
        $request->session()->forget('admin');
        return view('admin.login');
    }


    /**
     * 管理员列表
     */
    public function adminList()
    {
        $admins= Admin::all();
        return view('admin.admin.admin_list')->with('admins', $admins);
    }


    /**
     * 添加管理员
     */
    public function toAdminAdd()
    {
        return view('admin.admin.admin_add');
    }


    //********************************Service*******************************************//


    /**
     * 登录验证
     * @param Request $request
     * @return string
     */
    public function login(Request $request){

        $username = $request->get('username', '');
        $password = $request->get('password', '');
        $validate_code = $request->get('validate_code', '');


        $messageResult = new MessageResult();

        $validate_code_session = $request->session()->get('validate_code');

        if ($validate_code != $validate_code_session) {
            $messageResult->state=1;
            $messageResult->message='验证码不正确';
            return $messageResult->toJson();
        }
        $admin = Admin::where('username',$username)
                    ->where('is_delete',0)->first();

        if ($admin == null) {
            $messageResult->state=2;
            $messageResult->message='改用户被禁用或者用户不存在！';
            return $messageResult->toJson();
        } else {
            if (md5('xx_oo_pp_'.$password) != $admin->password) {
                $messageResult->state=3;
                $messageResult->message='密码不正确';
                return $messageResult->toJson();
            }
        }
        $request->session()->put('admin', $admin);

        $messageResult->state=0;
        $messageResult->message='登录成功';
        return $messageResult->toJson();

    }


    /**
     * 添加管理员
     * @param Request $request
     * @return string
     */
    public function adminAdd(Request $request)
    {
       $username = $request->input('username', '');
       $password = $request->input('password', '');
       $nikename = $request->input('nikename', '');
       $email = $request->input('email', '');

        $admin = new Admin();
        $admin->username = $username;
        $admin->nikename = $nikename;;
        $admin->password = md5('xx_oo_pp_'.$password);
        $admin->email = $email;
        $admin->save();


        $m_result = new MessageResult();
        $m_result->state = 0;
        $m_result->message = '添加成功';

        return $m_result->toJson();

    }

    /**
     * 停用账号
     * @param Request $request
     * @return string
     */
    public function adminStop(Request $request)
    {
        $id = $request->input('id', '');
        $admin = Admin::find($id);
        $admin->is_delete = 1;
        $admin->save();

        $message = new MessageResult();
        $message->state = 0;
        $message->message = '停用成功';

        return $message->toJson();
    }

    /**
     * 弹出修改密码窗口
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function toAdminEdit($id)
    {
        return view('admin.admin.admin_edit')->with('id',$id);
    }

    /**
     * 修改用户密码
     * @param Request $request
     * @return string
     */
    public function adminEdit(Request $request)
    {
        $messageResult = new MessageResult();
        $id = $request->input('id', '');
        $admin = Admin::find($id);
        if ($admin != null) {

            $old_password = $request->input('old_password', '');

            if (md5('xx_oo_pp_'.$old_password) != $admin->password){
                $messageResult->state = 3;
                $messageResult->message = '密码错误';
                return $messageResult->toJson();

            } else {

                $password = $request->input('password', '');
                $admin->password =  md5('xx_oo_pp_'.$password);;
                $admin->save();

                $messageResult->state = 0;
                $messageResult->message = '修改成功';
                return $messageResult->toJson();
            }
        } else {
            $messageResult->state =2;
            $messageResult->message = '用户不存在,信息出错联系管理员！';
            return $messageResult->toJson();
        }


    }
}
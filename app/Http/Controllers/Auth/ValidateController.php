<?php
/**
 * Created by IntelliJ IDEA.
 * User: Lan
 * Date: 2017/8/10
 * Time: 11:26
 */

namespace App\Http\Controllers\Auth;


use App\Http\Controllers\Controller;
use App\Tool\Validate\ValidateCode;
use Illuminate\Http\Request;

class ValidateController extends Controller
{
    /**
     * 生成验证码
     * @param Request $request
     * @return mixed
     */
    public function create(Request $request)
    {
        $validateCode = new ValidateCode;
        $request->session()->put('validate_code', $validateCode->getCode());
        return $validateCode->doimg();
    }

}
<?php
namespace App\Models;

class MessageResult{


    public $state;//状态码
    public $message;//返回消息

    public function toJson(){
        return json_encode($this, JSON_UNESCAPED_UNICODE);
    }
}

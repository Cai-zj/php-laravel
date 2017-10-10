<?php
/**
 * Created by IntelliJ IDEA.
 * User: caizhuojie
 * Date: 2017/9/30
 * Time: 10:38
 */

namespace App\Entity;


use Illuminate\Database\Eloquent\Model;


/**
 * 管理员表
 * Class Admin
 * @package App\Events
 */

class Admin extends Model

{
    protected $table = 'tb_admin';

    protected $primaryKey = 'id';

    protected $guarded =['id'];

}
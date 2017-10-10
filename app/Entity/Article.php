<?php
/**
 * Created by IntelliJ IDEA.
 * User: caizhuojie
 * Date: 2017/9/30
 * Time: 10:40
 */

namespace App\Entity;


use Illuminate\Database\Eloquent\Model;

/**
 * 文章表
 * Class Article
 * @package App\Events
 */
class Article extends Model
{
    protected $table = 'tb_article';

    protected $primaryKey = 'id';

    protected $guarded =['id'];
}
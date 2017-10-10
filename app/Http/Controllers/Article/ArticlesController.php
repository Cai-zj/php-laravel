<?php
namespace App\Http\Controllers\Article;
/**
 * Created by IntelliJ IDEA.
 * User: caizhuojie
 * Date: 2017/9/30
 * Time: 17:42
 */

use App\Entity\Article;
use App\Http\Controllers\Controller;

class ArticlesController extends Controller
{
    public function article()
    {
        $article = Article::where('is_delete', 0)->paginate(10);
        return view('article_list')->with('articles_list', $article);

    }
}
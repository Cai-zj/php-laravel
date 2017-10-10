<?php
/**
 * Created by IntelliJ IDEA.
 * User: caizhuojie
 * Date: 2017/9/30
 * Time: 11:58
 */

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Entity\Article;
use Illuminate\Http\Request;
use App\Models\MessageResult;

class ArticleController  extends Controller
{
    //********************************View*******************************************//

    /**
     * 文章列表
     * @return $this
     */
    public function articleList()
    {
        $articles = Article::where('is_delete', 0)->paginate(10);
        return view('admin.article.article_list')->with('articles', $articles);
    }

    /**
     * 文章添加页面
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function toArticleAdd()
    {
        return view('admin.article.article_add');
    }

    public function toArticleEdit(Request $request)
    {
        $id = $request->input('id', '');
        $article = Article::find($id);
        return view('admin.article.article_edit')->with('article', $article);
    }


    //********************************Service*******************************************//

    /**
     * 添加文章
     * @param Request $request
     * @return mixed
     */
    public function articleAdd(Request $request)
    {

        $title = $request->input('title', '');
        $like_count = $request->input('like_count', '');
        $view_count = $request->input('view_count','');
        $source = $request->input('source', '');
        $cover = $request->input('cover', '');
        $detail = $request->input('detail', '');

        if ($view_count == '') {
            $view_count = mt_rand(100, 1000);
        }
        if ($like_count == '') {
            $like_count = mt_rand(50, 200);
        }

        $article = new Article();
        $article->title = $title;
        $article->like_count = $like_count;
        $article->view_count = $view_count;
        $article->source = $source;
        $article->cover = $cover;
        $article->detail = $detail;

        $article->save();

        $m_result = new MessageResult();
        $m_result->state = 0;
        $m_result->message = '添加成功';

        return $m_result->toJson();
    }

    /**
     * 修改文章
     * @param Request $request
     * @return string
     */
    public function articleEdit(Request $request)
    {
        $id = $request->input('id', '');
        $title = $request->input('title', '');
        $like_count = $request->input('like_count', '');
        $view_count = $request->input('view_count','');
        $source = $request->input('source', '');
        $cover = $request->input('cover', '');
        $detail = $request->input('detail', '');

        $article = Article::find($id);
        $article->title = $title;
        $article->like_count = $like_count;
        $article->view_count = $view_count;
        $article->source = $source;
        $article->cover = $cover;
        $article->detail = $detail;

        $article->save();

        $m_result = new MessageResult();
        $m_result->state = 0;
        $m_result->message = '修改成功';

        return $m_result->toJson();

    }

    /**
     * 删除内容
     * @param Request $request
     * @return string
     * @internal param $id
     */
    public function articleDel(Request $request)

    {
        $id = $request->input('id', '');
        $article =  Article::find($id);
        $article->is_delete = 1;
        $article->save();

        $message = new MessageResult();
        $message->state = 0;
        $message->message = '删除成功';

        return $message->toJson();
    }
}
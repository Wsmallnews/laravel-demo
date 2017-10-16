<?php
namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Auth;
use App\Exceptions\MyException;
use App\Models\User;
use App\Models\Article;
use App\Models\ArticleCat;
use App\Http\Requests\ArticleRequest;

class ArticlesController extends CommonController {
    /**
     * Create a new controller instance.
     *
     * @return void
     */
	public function __construct()
	{
	    // $this->middleware('wechat.oauth');
	}


	public function index(Request $request) {
		if ($request->ajax()) {
            $articles = Article::with('articleCat')->paginate($request->input('page_size', 10));

            return response()->json([
                'error' => 0,
                'info' => '获取成功',
                'result' => $articles,
            ]);
        }

		return view("admin.articles.index", [
            "title" => "文章列表"
        ]);
	}


	public function show() {
		$article = Article::findOrFail($id);

		return view("admin.articles.show", [
			"title" => "文章添加",
			"article" => $article
		]);
	}


	public function create() {
		return view("admin.articles.create_and_edit", [
			"title" => "文章添加"
		]);
	}


	public function store(ArticleRequest $request, Article $article) {
        $article->title = $request->input('title');
		$article->cat_id = $request->input('cat_id');
        $article->images = json_encode($request->input('images'));
        $article->content = $request->input('content');
		$article->keywords = $request->input('keywords');
		$article->status = $request->input('status');
		$article->desc = $request->input('desc');
        $article->save();

        return response()->json(['error' => 0, 'info' => '保存成功']);
    }


	public function edit($id) {
		$article = Article::findOrFail($id);

		return view("admin.articles.create_and_edit", [
			"title" => "文章编辑",
			"article" => $article,
			"article_json" => json_encode($article)
		]);
	}


    public function update(ArticleRequest $request, $id) {
        $article = Article::findOrFail($id);

        if (!empty($article)) {
			$article->title = $request->input('title');
			$article->cat_id = $request->input('cat_id');
	        $article->images = json_encode($request->input('images'));
	        $article->content = $request->input('content');
			$article->keywords = $request->input('keywords');
			$article->status = $request->input('status');
			$article->desc = $request->input('desc');
            $article->save();

            return response()->json(['error' => 0, 'info' => '保存成功']);
        }
        return response()->json(['error' => 1002, 'info' => '保存失败']);
    }


	public function destroy($id) {
        $article = Article::findOrFail($id);

        $article->delete();
        return response()->json(['error' => 0, 'info' => '删除成功']);
    }

}

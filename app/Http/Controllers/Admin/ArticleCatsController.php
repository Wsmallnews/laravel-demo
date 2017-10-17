<?php
namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Models\ArticleCat;
use App\Exceptions\MyException;

class ArticleCatsController extends CommonController {
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
            $articleCats = ArticleCat::paginate($request->input('page_size', 10));

            return response()->json([
                'error' => 0,
                'info' => '获取成功',
                'result' => $articleCats,
            ]);
        }

		return view("admin.articleCats.index", [
            "title" => "文章分类列表"
        ]);
	}


	public function create() {
		return view("admin.articleCats.create_and_edit", [
			"title" => "文章分类添加"
		]);
	}


	public function store(ArticleCatRequest $request, ArticleCat $articleCat) {
		$articleCat->name = $request->input('name');
		$articleCat->parent_id = $request->input('parent_id');
		$articleCat->is_nav = $request->input('is_nav');
		$articleCat->sort_order = $request->input('sort_order');
		$articleCat->desc = $request->input('desc');
		$articleCat->save();

        return response()->json(['error' => 0, 'info' => '保存成功']);
    }


	public function edit($id) {
		$articleCat = ArticleCat::findOrFail($id);

		return view("admin.articles.create_and_edit", [
			"title" => "文章分类编辑",
			"articleCat" => $articleCat,
			"articleCat_json" => json_encode($articleCat)
		]);
	}


    public function update(ArticleCatRequest $request, $id) {
        $articleCat = ArticleCat::findOrFail($id);

        if (!empty($articleCat)) {
			$articleCat->name = $request->input('name');
			$articleCat->parent_id = $request->input('parent_id');
			$articleCat->is_nav = $request->input('is_nav');
			$articleCat->sort_order = $request->input('sort_order');
			$articleCat->desc = $request->input('desc');
            $articleCat->save();

            return response()->json(['error' => 0, 'info' => '保存成功']);
        }
        return response()->json(['error' => 1002, 'info' => '保存失败']);
    }


	public function destroy($id) {
        $articleCat = ArticleCat::findOrFail($id);

        $articleCat->delete();
        return response()->json(['error' => 0, 'info' => '删除成功']);
    }

}

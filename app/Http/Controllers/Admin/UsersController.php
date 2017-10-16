<?php
namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Models\User;
use Auth;
use App\Exceptions\MyException;

class UsersController extends CommonController {
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
            $users = User::paginate($request->input('page_size', 10));

            return response()->json([
                'error' => 0,
                'info' => '获取成功',
                'result' => $users,
            ]);
        }

		return view("admin.users.index", [
            "title" => "用户列表"
        ]);
	}
}

<?php
namespace App\Http\Controllers\Demo;

use Illuminate\Http\Request;
use App\Models\User;
use Auth;
use App\Exceptions\MyException;
use DB;

class IndexController extends CommonController {
    /**
     * Create a new controller instance.
     *
     * @return void
     */
	public function __construct()
	{
	    // $this->middleware('wechat.oauth');
	}


	public function index() {
		// 事务示例
		DB::transaction(function () {
			// sql1
			// sql2
			// .
			// .
			// .
		});

		// 抛出异常
		throw (new MyException)->setMessage("自定义错误码", 1101);
		throw new MyException("错误吗默认 500");
	}
}

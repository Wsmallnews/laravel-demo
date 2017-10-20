<?php
namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Models\User;
use Auth;
use App\Exceptions\MyException;
use DB;
use MyUpload;

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
		$result = MyUpload::uploadCopy('http://static.laravelacademy.org/wp-content/uploads/2015/12/qrcode-100.png', 'abc');
exit;
		return view("admin.index.index", [
            "title" => "欢迎"
        ]);
	}
}

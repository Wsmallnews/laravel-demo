<?php
namespace App\Http\Controllers\DeskApi;

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
		return view('welcome', [
			'wx_access_token' => session('wx_access_token')
		]);
	}
}

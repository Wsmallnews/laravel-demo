<?php
namespace App\Http\Controllers\DeskApi;

use App\Http\Controllers\Controller;
use Auth;

class CommonController extends Controller {

	public function __construct()
	{
	}

	/**
	 * 获取 auth 驱动，因为 config/auth.php 中default 为 web,此方法可以不予使用， 可直接 Auth::user(); 即为 web 驱动
	 * @author @smallnews 2017-06-03
	 * @return [type] [description]
	 */
	protected function guard()
    {
        return Auth::guard('web');
    }
}

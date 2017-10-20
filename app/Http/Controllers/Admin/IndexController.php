<?php
namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Models\User;
use Auth;
use App\Exceptions\MyException;
use DB;
use MyUpload;
use QrCode;

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
		// 生成二维码

		// 默认svg 格式
		// https://github.com/SimpleSoftwareIO/simple-qrcode/
		QrCode::generate('Hello,LaravelAcademy!', public_path('qrcodes/qrcode.svg'));
		QrCode::format('png')
			->encoding('UTF-8')
			->size(200)
			->color(255, 0, 255)
			->backgroundColor(255, 255, 0)
			->margin(1)
			->merge('/public/images/no_pic.jpg', .15)
			->generate('Hello,LaravelAcademy!', public_path('qrcodes/qrcode.png'));

		$qrcode = QrCode::format('png')->size(300)->generate('this is png encode!');
		return response($qrcode, 200)->header('Content-Type', "png");

		// https://github.com/spatie/laravel-permission

		// 文件拷贝
		// $result = MyUpload::uploadCopy('http://static.laravelacademy.org/wp-content/uploads/2015/12/qrcode-100.png', 'abc');


		// return view("admin.index.index", [
        //     "title" => "欢迎"
        // ]);
	}
}

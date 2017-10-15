<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;
use MyUpload;
use Image;

class FilesController extends Controller
{
    public function upload(Request $request){
        if ($request->hasFile('FileContent')){
            $result = MyUpload::upload($request->file('FileContent'), $request->input('file_type', 'avatars'));
            if (!$result['error']) {
                $result['filename'] = normalizerUrl(config('app.url')."/".config('app.www_dir')."/files/fileOper/".$result['data']['url']);
            }
        }else {
            $result = [
                'error' => 1,
                'info' => '文件不存在'
            ];
        }

        return response()->json($result);
    }


    public function myEditorUpload(Request $request) {
        $action = $request->input('action', 'uploadimage');

        if ($action == 'uploadimage') {
            if ($request->hasFile('FileContent')){
                $ret = MyUpload::upload($request->file('FileContent'), $request->input('file_type', 'avatars'));
                if (!$ret['error']) {
                    $result = array(
                        "state" => "SUCCESS",
                        "url" => $ret['data']['url'],
                        "title" => basename($ret['data']['url']),
                        "original" => basename($ret['data']['url'])
                    );
                }else {
                    $result = [
                        'state' => $ret['info'],
                        "url" => "",
                        'title' => "",
                        "original" => ""
                    ];
                }
            }else {
                $result = [
                    'state' => "文件不存在",
                    "url" => "",
                    'title' => "",
                    "original" => ""
                ];
            }
        }else if ($action == 'config') {
            $config = array(
                /* 上传图片配置项 */
                "imageActionName" => "uploadimage", /* 执行上传图片的action名称 */
                "imageFieldName" => "FileContent", /* 提交的图片表单名称 */
                "imageMaxSize" => 1024000000, /* 上传大小限制 (10M)，单位B */
                "imageAllowFiles" => [".png", ".jpg", ".jpeg", ".gif", ".bmp"], /* 上传图片格式显示 */
                "imageCompressEnable" => true, /* 是否压缩图片,默认是true */
                "imageCompressBorder" => 1600, /* 图片压缩最长边限制 */
                "imageInsertAlign" => "none", /* 插入的图片浮动方式 */
                "imageUrlPrefix" => "", /* 图片访问路径前缀 */
                // "imagePathFormat" => "/ueditor/php/upload/image/{yyyy}{mm}{dd}/{time}{rand:6}",
            );

            return response()->json($config);
        }

        return response()->json($result);
    }


    public function fileOper(Request $request, $path = ""){
        // $path = str_replace("storage", "", $path);
		// $mime_type = MyUpload::driver()->mimeType($path);
		// $file = MyUpload::driver()->get($path);
        // return response($file, 200)->header('Content-Type',$mime_type);

        // $url = $request->getRequestUri();
        // $url_parse = parse_url($url);
        // $format = $url_parse['query'];

        $format = $request->input('format', '');

        // $path = public_path().str_replace("public", "", $path);
        $path = storage_path('app')."/".str_replace("storage", "", $path);
        if (file_exists($path)) {
            $img = Image::make($path);

            if (!empty($format)) {
                if (stripos(strtoupper($format), 'X') !== false) {
                    $format_arr = explode('X', $format);
                    $img->fit($format_arr[0], $format_arr[1]);
                }else {
                    $img->fit($format, $format);
                }
            }

            return response($img->encode(), 200)->header('Content-Type', $img->mime);
        }else {
            $img = Image::make(public_path()."/images/no_pic.jpg");
            $img->fit($format, $format);
            return response($img->encode(), 404)->header('Content-Type', $img->mime);
        }
    }
}

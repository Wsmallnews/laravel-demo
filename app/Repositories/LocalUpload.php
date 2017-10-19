<?php namespace App\Repositories;

use Session;
use Image;
use Storage;
use App\Contracts\MyUpload;

class LocalUpload implements MyUpload{
	private $file = '';
	private $type = '';
	private $extension = '';		//图片后缀名
	private $tmp_path = '';			//临时文件路径
	private $filename = '';			//生成文件文件名，不带后缀
	private $filesize = '';			//文件大小
	private $base_dir = '';			// 基础目录，解决访问存储路径不一致
	private $upload_dir = '';			//图片真实保存目录
	private $base_url = '';			// 基础图片路径，解决访问存储路径不一致
	private $upload_url = '';			//图片真实保存目录


	public function upload($file, $type = 'avatars'){
		//文件的扩展名
		$this->file = $file;
		$this->type = $type;
		$this->extension = strtolower($file->getClientOriginalExtension());	//获取文件的扩展名
		$this->tmp_path = $file->getRealPath();	//这个表示的是缓存在tmp文件夹下的文件的绝对路径
		$this->filename = strtolower($file->hashName());		// 根据hash 值 生成文件名
        $this->filesize = $file->getClientSize();

		return $this->saveFile();
	}


	/**
	 * 远程图片 复制 转存 折中方法，保存本地，之后再上传
	 * @author @smallnews 2017-05-15
	 * @return [type] [description]
	 */
	// public function uploadCopy($file_src, $type = 'avatars'){
	// 	$img = Image::make($file_src);
	//
	// 	$mime = $img->mime();
	// 	$mime = explode('/', $mime);
	//
	// 	$this->type = $type;
	// 	$this->extension = $mime[count($mime)-1];
	// 	$this->tmp_path = $file_src;
	// 	$this->filename = $this->getHashName();
	// 	$this->filesize = $img->filesize();
	//
	// 	$save_tmp_path = public_path().'/tmp_file/'.$this->filename;
	// 	$img->save($save_tmp_path);
	//
	// 	$this->tmp_path = $save_tmp_path; 	// 重新定义 tmp_path
	//
	// 	$res = $this->saveFile();
	// 	@unlink($save_tmp_path);
	// 	return $res;
	// }


	/**
	 * 本地 资源文件 转存到 cos，js css
	 * @author @smallnews 2017-06-08
	 * @param  [type] $file_src [description]
	 * @param  string $type     [description]
	 * @return [type]           [description]
	 */
	// public function uploadAsset($file_src, $save_path = '/asset/'){
	// 	$this->makeDirectory($save_path);
	//
	// 	$save_name = $this->normalizerPath($save_path."/".basename($file_src));
	// 	$ret = $this->driver()::upload($file_src, $save_name);
	//
	// 	if ($ret['code']){
	// 		return $this->returnMessage("上传失败", 1);
	// 	} else {
	// 		return $this->returnMessage("上传成功", 0);
	// 	}
	// }



	private function saveFile(){
		// 设置上传目录
		$this->upload_dir = $this->createUploadDir($this->type);
		// echo "----------------------------------------<br>";
// echo file_get_contents($this->tmp_path);
		// 获取上传路径
		$this->upload_url = $this->getUploadUrl();

		if(!$this->exists($this->upload_url)){
			// echo "----------------------------------------<br>";
			// echo file_get_contents($this->tmp_path);								// 能拿到 文件
			// $ret = $this->driver()->move($this->tmp_path, $this->upload_url);	// 找不到文件（tmp_path）
			// $ret = Storage::putFileAs('', $this->file, $this->upload_url);		// 5.2 没有 putFiles
			$ret = $this->file->move(storage_path('app')."/".$this->upload_dir, $this->filename);
			// $ret = Storage::put($this->upload_url, Image::make($this->tmp_path)->encode());
			if ($ret){
				return $this->returnMessage("上传成功", 0, [
					'url' => $this->fullUrl($this->base_url),
					// 'original' => $this->normalizerPath($this->upload_dir, $this->filename)		// 原始地址
				]);
			} else {
				return $this->returnMessage("上传失败", 1);
			}
		}else{
			return $this->returnMessage("上传成功", 0, [
				'url' => $this->fullUrl($this->base_url),
				// 'original' => $this->normalizerPath($this->upload_dir, $this->filename)			// 原始地址
			]);
		}
	}

	private function getHashName(){
		return md5_file($this->tmp_path).'.'.$this->extension;
	}


	/**
	 * 目录完整路径
	 * @author @smallnews 2017-05-08
	 * @param  [type] $type [description]
	 * @return [type]       [description]
	 */
	private function createUploadDir($type){
		$date_dir = date('Ymd');

		$this->base_dir = $type.'/'.$date_dir.'/';
		$upload_dir = 'public/'.$type.'/'.$date_dir.'/';

		if ($this->makeDirectory($upload_dir)){
			return $upload_dir;
		}
	}

	/**
	 * 文件完整路径
	 * @author @smallnews 2017-05-08
	 * @param  [type] $type [description]
	 * @return [type]       [description]
	 */
	private function getUploadUrl(){
		$this->base_url = $this->base_dir . $this->filename;
		return $this->upload_dir . $this->filename;
	}

	/**
	 * 创建目录
	 * @author @smallnews 2017-05-08
	 * @param  [type] $dir [description]
	 * @return [type]      [description]
	 */
	private function makeDirectory($dir){
		Storage::makeDirectory($dir);

		return true;
	}


	/**
	 * 目录是否存在
	 * @author @smallnews 2017-05-10
	 * @param  [type] $path [description]
	 * @return [type]       [description]
	 */
	private function existsFolder($path){

	}


	/**
	 * 文件是否存在
	 * @author @smallnews 2017-05-10
	 * @param  [type] $path [description]
	 * @return [type]       [description]
	 */
	private function exists($path){
		return $this->driver()->has($path);
	}


	/**
	 * 返回完整 url
	 * @author @smallnews 2017-05-10
	 * @param  [type] $upload_url [description]
	 * @return [type]             [description]
	 */
	private function fullUrl($base_url){
		$upload_url = $this->normalizerPath("/public/storage/".$base_url);

		$full_url = $upload_url;

		return $full_url;
	}


	/**
	 * 优化 url 图片地址
	 * @author @smallnews 2017-05-10
	 * @param  [type] $path [description]
	 * @return [type]       [description]
	 */
	public function normalizerPath($path) {
		$path = preg_replace('#/+#', '/', $path);	// 如果中间出现  // 或者 ///... 替换成 /

		if (!preg_match('/^(\/)/', $path)) {
			$path = "/".$path;
		}

		return $path;
	}


	private function returnMessage($info, $error = 0, $data = []){
		return [
			'error' => $error,
			'info' => $info,
			'data' => $data
		];
	}


	public function driver($driver = 'local'){
		return Storage::disk($driver);
	}
}

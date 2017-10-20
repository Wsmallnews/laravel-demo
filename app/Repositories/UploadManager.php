<?php namespace App\Repositories;

use Session;
use Image;
use Storage;
use App\Contracts\MyUpload;
use Illuminate\HTTP\File;

class UploadManager implements MyUpload{
	private $file = '';
	private $type = '';
	private $extension = '';		//图片后缀名
	// private $tmp_path = '';			//临时文件路径
	private $filename = '';			//生成文件文件名，不带后缀
	private $filesize = '';			//文件大小
	// private $base_dir = '';			// 基础目录，解决访问存储路径不一致
	private $upload_dir = '';			//图片真实保存目录
	// private $base_url = '';			// 基础图片路径，解决访问存储路径不一致
	private $upload_url = '';			//图片真实保存目录


	public function upload($file, $type = 'avatars'){
		//文件的扩展名
		$this->file = $file;
		$this->type = $type;
		$this->extension = strtolower($file->getClientOriginalExtension());	//获取文件的扩展名
		// $this->tmp_path = $file->getRealPath();	//这个表示的是缓存在tmp文件夹下的文件的绝对路径
		$this->filename = strtolower($file->hashName());		// 根据hash 值 生成文件名
        $this->filesize = $file->getClientSize();

		return $this->saveFile();
	}


	/**
	 * 远程图片 复制 转存 折中方法，保存本地，之后再上传
	 * @author @smallnews 2017-05-15
	 * @return [type] [description]
	 */
	public function uploadCopy($file_src, $type = 'avatars'){
        $client = new \GuzzleHttp\Client();
        $response = $client->get($file_src);
        $body = $response->getBody()->getContents();	// 图片数据流

		$this->file = $body;

		$img = Image::make($body)->encode();
		$mime = $img->mime();
		$mime = explode('/', $mime);

		$this->type = $type;
		$this->extension = $mime[count($mime)-1];
		$this->filename = $this->getHashName($file_src);
		$this->filesize = $img->filesize();

		return $this->saveFile(true);
	}


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
	// 	$ret = $this->disk()::upload($file_src, $save_name);
	//
	// 	if ($ret['code']){
	// 		return $this->returnMessage("上传失败", 1);
	// 	} else {
	// 		return $this->returnMessage("上传成功", 0);
	// 	}
	// }



	private function saveFile($is_stream = false){
		// 设置上传目录
		$this->upload_dir = $this->createUploadDir($this->type);		// 上传目录	articles/20171020
		$this->upload_url = $this->getUploadUrl();						// 上传文件 articles/20171020/2xjx4yhgq.png

		if(!$this->exists($this->upload_url)){
			if ($is_stream) {
				$ret = $this->disk()->put($this->upload_url, $this->file);	// $this->file 是数据流，第一个参数需要带上文件Ing
			} else {
				$ret = $this->disk()->put($this->upload_dir, $this->file);	// $this->file 是File 对象，不需要文件名
			}

			if ($ret){
				return $this->returnMessage("上传成功", 0, [
					'url' => $this->disk()->url($this->upload_url),
					'origin_url' => $this->upload_url
				]);
			} else {
				return $this->returnMessage("上传失败", 1);
			}
		}else{
			return $this->returnMessage("上传成功", 0, [
				'url' => $this->disk()->url($this->upload_url),
				'origin_url' => $this->upload_url
			]);
		}
	}


	/**
	 * hash 文件名
	 * @return [type] [description]
	 */
	private function getHashName($file_path){
		return md5_file($file_path).'.'.$this->extension;
	}


	/**
	 * 目录完整路径
	 * @author @smallnews 2017-05-08
	 * @param  [type] $type [description]
	 * @return [type]       [description]
	 */
	private function createUploadDir($type){
		$date_dir = date('Ymd');
		$upload_dir = $type.'/'.$date_dir.'/';

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
		return $this->upload_dir . $this->filename;
	}

	/**
	 * 创建目录
	 * @author @smallnews 2017-05-08
	 * @param  [type] $dir [description]
	 * @return [type]      [description]
	 */
	private function makeDirectory($dir){
		$this->disk()->makeDirectory($dir);

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
		return $this->disk()->has($path);
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


	public function disk($disk = ''){
		$disk = !empty($disk) ? $disk : $this->getDefault();
		return Storage::disk($disk);
	}

	private function getDefault(){
		return config('filesystems.default');
	}
}

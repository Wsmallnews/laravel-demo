<?php namespace App\Repositories;

use App\Contracts\MyUpload;
use App\Http\Requests;
// use Session;
use Image;
use Storage;

class UploadManager implements MyUpload {

	// private $img = '';				//图片对象
	// private $save_path = '';		//最终文件保存路径
	// private $mime_type = '';		//文件mime 类型
	// private $extension = '';		//图片后缀名
	// private $tmp_path = '';			//临时文件路径
	// private $dir = '/';		//上传文件保存根目录
	// private $real_dir = '';			//图片真实保存目录
	// private $filename = '';			//生成文件文件名，不带后缀
    // private $filesize = '';			//文件大小

	protected $extension = '';		//图片后缀名
	protected $tmpPath = '';			//临时文件路径
	protected $mimeType = '';			//图片真实保存目录
	protected $filename = '';			//生成文件文件名，不带后缀
    protected $filesize = '';			//文件大小

	protected $img = '';			//原始文件

	protected $storage = [];		// 文件存储驱动

	protected $cutConfig = [];

	public function __construct(){

	}


	/**
	 * 图片裁剪尺寸
	 * @author @smallnews 2017-04-15
	 * @param  [type] $name [description]
	 * @return [type]       [description]
	 */
	public function cutConfig($name){
		$this->cutConfig = $cutSize = $this->getConfig($name);

		return $this;
	}


	// 文件处理模式
	public function mode($name, $file = null){
		$file = $file ? : $this->getDefaultFile();

		// $this->setProperty($file);			// 将文件的属性保存的 当前对象的属性中
		$this->img = Image::make($this->tmp_path);		// 创建图片对象

		$uploadMode = 'upload'.ucfirst($name).'Mode';

        if (method_exists($this, $uploadMode)) {
            return $this->{$uploadMode}();
        } else {
            throw new InvalidArgumentException("UploadMode [{$name}] is not supported.");
        }
	}


	/*
		文件上传模式
	 */
	protected function uploadFileMode(){



	}


	/**
	 * 图片上传模式
	 */
	protected function uploadImageMode(){
		$cutConfig = $this->cutConfig;

		$cutMode = 'cut'.ucfirst($cutConfig['type']).'Mode';

		if (!method_exists($this, $driverMethod)) {
            throw new InvalidArgumentException("CutMode [{$config['driver']}] is not supported.");
        }

		foreach ($cutConfig['aspect'] as $key => $value) {
			$this->{$cutMode}($value);
		}
	}


	/**
	 * 正方形裁剪
	 * @author @smallnews 2017-04-15
	 * @return [type] [description]
	 */
	protected function cutSquareMode($size, $default = false){
		if (is_array($size)) {
			$size = $size[0];
		}

		$img = $this->img;
		$img->fit($size, $size);

		$save_tmp_path = public_path().'/tmp_file/'.$this->filename;
		$img->save($save_tmp_path);

		$this->saveFile($save_tmp_path, $default);
	}


	protected function saveFile($file, $default){
		$save_path = $this->getPath($default);

		$this->storage->put($save_path, $save_tmp_path);
	}


	// 有待优化
	protected function getPath($default){
		if ($default) {
			$this->returnPath = $save_path = $this->setDir()."/".$this->filename;
		}else {
			$save_path = $this->setDir()."/".$this->filename."_".$size.'.'.$this->entension;
		}

		return $save_path;
	}


	//设置文件保存目录
	protected function setDir(){
		$real_dir = '/'.date('Ymd').'/';

		$this->storage->makeDirectory($this->real_dir);

		return $real_dir;
	}

	protected function setProperty($file){
		$this->extension = $file->getClientOriginalExtension();
		$this->tmpPath = $file->getRealPath();
		$this->mimeType = $file->getMimeType();
		$this->filename = $file->hashName();
	    $this->filesize = $file->getClientSize();
	}


	/*
		获取 驱动
	 */
	public function drive($name = null)
    {
        $name = $name ?: $this->getDefaultDriver();

		$this->storage = Storage::disk($name);

		return $this;
    }


	protected function getConfig($name)
    {
        return $this->app['config']["uploadsize.mode.{$name}"];
    }


	protected function getDefaultFile(){
		if (Requests::hasFile('file')) {
			return Requests::file('file');
		}else {
			abort('404');
		}
	}


	/**
     * Get the default driver name.
     *
     * @return string
     */
    protected function getDefaultDriver()
    {
        return $this->app['config']['uploadsize.default'];
    }
}

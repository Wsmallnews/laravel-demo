<?php
namespace App\Repositories\QCos;

use QCloud\Cos\Api as CosApi;

class QCosOper
{
    static $conf;
    static private $bucket;
    public $cosApi = null;

    public function __construct($config)
    {
        self::$conf = $config;
        self::$bucket = self::$conf['bucket'];

        $this->cosApi = $cosApi = new CosApi($config);
    }


    public function setBucket($bucket) {
        self::$bucket = $bucket ? : self::$bucket;
    }


    public function getBucket() {
        return self::$bucket;
    }


    public function getAppId()
    {
        return self::$conf['app_id'];
    }

    /*
     * 创建目录
     * @param  string  $bucket bucket名称
     * @param  string  $folder       目录路径
     * @param  string  $bizAttr    目录属性
     */
    public function createFolder($folder, $bizAttr = null)
    {
        $bucket = $this->getBucket();
        $ret = $this->cosApi->createFolder($bucket, $folder, $bizAttr);
        return $ret;
    }

    /**
     * 上传文件,自动判断文件大小,如果小于20M则使用普通文件上传,大于20M则使用分片上传
     * @param  string  $bucket   bucket名称
     * @param  string  $srcPath      本地文件路径
     * @param  string  $dstPath      上传的文件路径
     * @param  string  $bizAttr      文件属性
     * @param  string  $slicesize    分片大小(512k,1m,2m,3m)，默认:1m
     * @param  string  $insertOnly   同名文件是否覆盖
     * @return [type]                [description]
     */
    public function upload($srcPath, $dstPath, $bizAttr=null, $sliceSize=null, $insertOnly=null)
    {
        $bucket = $this->getBucket();
        $ret = $this->cosApi->upload($bucket, $srcPath, $dstPath, $bizAttr, $sliceSize, $insertOnly);
        return $ret;
    }

    /*
     * 目录列表
     * @param  string  $bucket bucket名称
     * @param  string  $path     目录路径，sdk会补齐末尾的 '/'
     * @param  int     $num      拉取的总数
     * @param  string  $pattern  eListBoth,ListDirOnly,eListFileOnly  默认both
     * @param  int     $order    默认正序(=0), 填1为反序,
     * @param  string     透传字段,用于翻页,前端不需理解,需要往前/往后翻页则透传回来
     */
    public function listFolder($folder, $num = 20, $pattern = 'eListBoth', $order = 0, $context = null)
    {
        $bucket = $this->getBucket();
        $ret = $this->cosApi->listFolder($bucket, $folder, $num, $pattern, $order, $context);
        return $ret;
    }

    /*
     * 目录列表(前缀搜索)
     * @param  string  $bucket bucket名称
     * @param  string  $prefix   列出含此前缀的所有文件
     * @param  int     $num      拉取的总数
     * @param  string  $pattern  eListBoth(默认),ListDirOnly,eListFileOnly
     * @param  int     $order    默认正序(=0), 填1为反序,
     * @param  string     透传字段,用于翻页,前端不需理解,需要往前/往后翻页则透传回来
     */
    public function prefixSearch($prefix, $num = 20, $pattern = 'eListBoth', $order = 0, $context = null)
    {
        $bucket = $this->getBucket();
        $ret = $this->cosApi->prefixSearch($bucket, $prefix, $num, $pattern, $order, $context);
        return $ret;
    }

    /*
     * 目录更新
     * @param  string  $bucket bucket名称
     * @param  string  $folder      文件夹路径,SDK会补齐末尾的 '/'
     * @param  string  $bizAttr   目录属性
     */
    public function updateFolder($folder,$bizAttr = null)
    {
        $bucket = $this->getBucket();
        $ret = $this->cosApi->updateFolder($bucket, $folder, $bizAttr);
        return $ret;
    }

    /*
      * 查询目录信息
      * @param  string  $bucket bucket名称
      * @param  string  $folder       目录路径
      */
    public function statFolder($folder)
    {
        $bucket = $this->getBucket();
        $ret = $this->cosApi->statFolder($bucket, $folder);
        return $ret;
    }

    /*
     * 查询文件信息
     * @param  string  $bucket  bucket名称
     * @param  string  $path        文件路径
     */
    public function stat($path)
    {
        $bucket = $this->getBucket();
        $ret = $this->cosApi->stat($bucket, $path);
        return $ret;
    }

    /**
     * Copy a file.
     * @param $bucket bucket name.
     * @param $srcFpath source file path.
     * @param $dstFpath destination file path.
     * @param $overwrite if the destination location is occupied, overwrite it or not?
     * @return array|mixed.
     */
    public function copyFile($srcFpath, $dstFpath, $overwrite = false)
    {
        $bucket = $this->getBucket();
        $ret = $this->cosApi->copyFile($bucket, $srcFpath, $dstFpath, $overwrite);
        return $ret;
    }

    /**
     * Move a file.
     * @param $bucket bucket name.
     * @param $srcFpath source file path.
     * @param $dstFpath destination file path.
     * @param $overwrite if the destination location is occupied, overwrite it or not?
     * @return array|mixed.
     */
    public function moveFile($srcFpath, $dstFpath, $overwrite = false)
    {
        $bucket = $this->getBucket();
        $ret = $this->cosApi->moveFile($bucket, $srcFpath, $dstFpath, $overwrite);
        return $ret;
    }

    /*
     * 删除文件
     * @param  string  $bucket
     * @param  string  $path      文件路径
     */
    public function delFile($path)
    {
        $bucket = $this->getBucket();
        $ret = $this->cosApi->delFile($bucket, $path);
        return $ret;
    }

    /*
     * 删除目录
     * @param  string  $bucket bucket名称
     * @param  string  $folder       目录路径
     *  注意不能删除bucket下根目录/
     */
    public function delFolder($folder)
    {
        $bucket = $this->getBucket();
        $ret = $this->cosApi->delFolder($bucket, $folder);
        return $ret;
    }

}

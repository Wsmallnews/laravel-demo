<?php
namespace App\Repositories\QCos;

use League\Flysystem\Adapter\AbstractAdapter;
use League\Flysystem\Adapter\Polyfill\NotSupportingVisibilityTrait;
use League\Flysystem\Adapter\Polyfill\StreamedReadingTrait;
use League\Flysystem\Config;
use App\Repositories\QCos\QCosOper;

class QCosAdapter extends AbstractAdapter
{
    public $qCosOper = null;
    public function __construct(QCosOper $client) {
        $this->qCosOper = $client;
    }

    /**
     * Check whether a file exists.
     *
     * @param string $path
     *
     * @return array|bool|null
     */
    public function has($path) {
        $ret = $this->qCosOper->stat($path);
        return $ret['code'] == 0 ? true : false;
    }

    /**
     * Read a file.
     *
     * @param string $path
     *
     * @return array|false
     */
    public function read($path) {
        echo "read";exit;
    }

    /**
     * Read a file as a stream.
     *
     * @param string $path
     *
     * @return array|false
     */
    public function readStream($path) {
        echo "readStream";exit;
    }

    /**
     * List contents of a directory.
     *
     * @param string $directory
     * @param bool   $recursive
     *
     * @return array
     */
    public function listContents($directory = '', $recursive = false) {
        echo "listContents";exit;
    }

    /**
     * Get all the meta data of a file or directory.
     *
     * @param string $path
     *
     * @return array|false
     */
    public function getMetadata($path) {
        echo "getMetadata";exit;
    }

    /**
     * Get the size of a file.
     *
     * @param string $path
     *
     * @return array|false
     */
    public function getSize($path) {
        echo "getSize";exit;
    }

    /**
     * Get the mimetype of a file.
     *
     * @param string $path
     *
     * @return array|false
     */
    public function getMimetype($path) {
        echo "getMimetype";exit;
    }

    /**
     * Get the timestamp of a file.
     *
     * @param string $path
     *
     * @return array|false
     */
    public function getTimestamp($path) {
        echo "getTimestamp";exit;
    }

    /**
     * Get the visibility of a file.
     *
     * @param string $path
     *
     * @return array|false
     */
    public function getVisibility($path) {
        echo "getVisibility";exit;
    }


    /**
     * Write a new file.
     *
     * @param string $path
     * @param string $contents
     * @param Config $config   Config object
     *
     * @return array|false false on failure file meta data on success
     */
    public function write($path, $contents, Config $config) {
        $ret = $this->saveAs($path, $contents, $config);
        return $ret['code'] == 0 ? true : false;
    }

    /**
     * Write a new file using a stream.
     *
     * @param string   $path
     * @param resource $resource
     * @param Config   $config   Config object
     *
     * @return array|false false on failure file meta data on success
     */
    public function writeStream($path, $resource, Config $config) {
        $ret = $this->saveAs($path, $resource, $config);
        return $ret['code'] == 0 ? true : false;
    }

    // 转存 保存
    private function saveAs ($path, $contents, Config $config){
        $tmp_path = storage_path('app')."/temp/".basename($path);
        file_put_contents($tmp_path, $contents);

        $ret = $this->qCosOper->upload($tmp_path, $path);
        @unlink($tmp_path);
        return $ret;
    }

    /**
     * Update a file.
     *
     * @param string $path
     * @param string $contents
     * @param Config $config   Config object
     *
     * @return array|false false on failure file meta data on success
     */
    public function update($path, $contents, Config $config) {
        echo "update";exit;
    }

    /**
     * Update a file using a stream.
     *
     * @param string   $path
     * @param resource $resource
     * @param Config   $config   Config object
     *
     * @return array|false false on failure file meta data on success
     */
    public function updateStream($path, $resource, Config $config) {
        echo "updateStream";exit;
    }

    /**
     * Rename a file.
     *
     * @param string $path
     * @param string $newpath
     *
     * @return bool
     */
    public function rename($path, $newpath) {
        $ret = $this->qCosOper->moveFile($path, $newpath);
        return $ret['code'] == 0 ? true : false;
    }

    /**
     * Copy a file.
     *
     * @param string $path
     * @param string $newpath
     *
     * @return bool
     */
    public function copy($path, $newpath) {
        $ret = $this->qCosOper->copyFile($path, $newpath);
        return $ret['code'] == 0 ? true : false;
    }

    /**
     * Delete a file.
     *
     * @param string $path
     *
     * @return bool
     */
    public function delete($path) {
        $ret = $this->qCosOper->delFile($path);
        return $ret['code'] == 0 ? true : false;
    }

    /**
     * Delete a directory.
     *
     * @param string $dirname
     *
     * @return bool
     */
    public function deleteDir($dirname) {
        $ret = $this->qCosOper->delFolder($dirname);
        return $ret['code'] == 0 ? true : false;
    }

    /**
     * Create a directory.
     *
     * @param string $dirname directory name
     * @param Config $config
     *
     * @return array|false
     */
    public function createDir($dirname, Config $config) {
        $ret = $this->qCosOper->createFolder($dirname);
        return $ret['code'] == 0 ? true : false;
    }

    /**
     * Set the visibility for a file.
     *
     * @param string $path
     * @param string $visibility
     *
     * @return array|false file meta data
     */
    public function setVisibility($path, $visibility) {
        echo "setVisibility";exit;
    }

    public function getUrl($path) {
        return $this->qCosOper::$conf['url'].$path;
    }
}

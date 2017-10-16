<?php
namespace App\Exceptions;

use Exception;

class MyException extends Exception
{

    /**
     * 多样化错误信息组合，非必须使用
     * throw (new MyException)->setMessage("错了");
     */
    public function setMessage($message = '', $error = 500)
    {
        // 错误信息组合模式
        $this->message = $message;
        $this->errorCode = $error;

        return $this;
    }
}

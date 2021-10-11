<?php

namespace App\Exceptions;

use Exception;

class ApiException extends Exception
{
    /**
     * 状态码
     * @var int|mixed
     */
    public $code = 1;

    /**
     * 错误具体信息
     * @var mixed|string
     */
    public $message = '';

    /**
     * 错误数据
     * @var array
     */
    public $data = [];


    /**
     * 构造函数，接收关联数组
     * BusinessException constructor.
     * @param string $message 提示消息
     * @param int $code 0-成功 非0异常
     */
    public function __construct(string $message, int $code = 400, array $data = [])
    {
        parent::__construct();
        $this->code = $code;
        $this->message = $message;
        $this->data = $data;
    }
}

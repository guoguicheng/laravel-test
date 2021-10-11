<?php

namespace App\Exceptions;

use Exception;
use App\Exceptions\ApiException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        ApiException::class
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
     */
    protected $dontFlash = [
        'password',
        'password_confirmation',
    ];

    /**
     * Report or log an exception.
     *
     * This is a great spot to send exceptions to Sentry, Bugsnag, etc.
     *
     * @param  \Exception  $exception
     * @return void
     */
    public function report(Exception $exception)
    {
        $error = [
            'error' => $exception->getMessage(),
            'errno' => $exception->getCode(),
            'errfile' => $exception->getFile(),
            'errline' => $exception->getLine(),
            'errstr' => $exception->getTraceAsString()
        ];
        $this->reportError($error);
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Exception  $exception
     * @return \Illuminate\Http\Response
     */
    public function render($request, Exception $exception)
    {
        if ($exception instanceof ApiException) {
            $this->code    = $exception->code;
            $this->message = $exception->message;
            $result = [
                'message'   => $this->message,
                'data' => $exception->data
            ];
            return response()->json($result, $exception->code)
                ->setEncodingOptions(JSON_UNESCAPED_UNICODE);
        }
        return parent::render($request, $exception);
    }

    /**
     * 其中$context参数是一个数组，下标有：
     *   error：错误类型，有：Error、Warning、Notice、Strict、Deprecated
     *   errno：错误值，整数，PHP定义的错误，包含了错误的级别，是一个 integer
     *   errstr：包含了错误的信息，是一个 string
     *   errfile：包含了发生错误的文件名，是一个 string
     *   errline：包含了错误发生的行号，是一个 integer
     *   time: 当时时间戳
     */
    protected function reportError($context)
    {
        if (config('app.env') == 'local') {
            return;
        }
        $url = 'https://qyapi.weixin.qq.com/cgi-bin/webhook/send?key=33658252-035d-48a6-be1d-90c33f9113a8';

        $data = json_encode(['msgtype' => 'markdown', 'markdown' => [
            'content' => "异常报告：\n"
                . "错误类型:" . $context['error'] . "\n"
                . "错误代码:" . $context['errno'] . "\n"
                . "文件:" . $context['errfile'] . "\n"
                . "行数:" . $context['errline'] . "\n"
                . "时间:" . date('Y-m-d H:i:s', time()) . "\n"
                . "<font color=\"warning\">" . $context['errstr'] . "</font>\n"

        ]]);
        $ch = curl_init(); //初始化CURL句柄 
        curl_setopt($ch, CURLOPT_URL, $url); //设置请求的URL
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-type:application/json'));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); //设为TRUE把curl_exec()结果转化为字串，而不是直接输出 
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST"); //设置请求方式
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data); //设置提交的字符串
        curl_exec($ch);
        curl_close($ch);
    }
}

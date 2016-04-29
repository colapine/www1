<?php

namespace Cp\Response;

/**
 * 为前端 前后端异步传值规范 所设计的统一输出结构
 *
 */
class Ajax
{

    /**
     * 所请允许的状态码
     *
     * @var array
     */
    protected $statusArr = array(
        'success', /* 成功 */
        'error', /* 失败 */
        'servererror', /* 请求出错，内部处理 */
        'authexpired', /* 授权过期 */
    );

    /**
     * 状态码
     *
     * @var string
     */
    protected $status = 'success';

    /**
     * 错误码
     *
     * @var int
     */
    protected $errorCode = 0;

    /**
     * 错误内容
     *
     * @var string
     */
    protected $errorMsg = '';

    /**
     * 资源
     *
     * @var array|mixed
     */
    protected $result = array();

    /**
     * @param \Exception|null $exception 如果是 Exception 类, 那么自动填充 status, errorCode, errorMsg 属性
     */
    public function __construct($exception = null)
    {
        if ($exception instanceof \Exception) {
            $this->setStatus('error');
            $this->setErrorCode($exception->getCode());
            $this->setErrorMsg($exception->getMessage());
        }
    }

    /**
     * 转成JSON格式的字符串
     *
     * @return string
     */
    public function __toString()
    {
        return $this->toJson();
    }

    /**
     * 获取 状态码
     *
     * @return string
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * 获取 错误说明
     *
     * @return string
     */
    public function getErrorMsg()
    {
        return $this->errorMsg;
    }

    /**
     * 获取 错误编码
     *
     * @return int
     */
    public function getErrorCode()
    {
        return $this->errorCode;
    }

    /**
     * 获取 资源
     *
     * @return array|mixed
     */
    public function getResult()
    {
        return $this->result;
    }

    /**
     * 状态码
     *
     * 仅允许以下几个种类型:
     * 1. 'success', 成功
     * 2. 'error', 失败
     * 3. 'servererror', 请求出错，内部处理
     * 4. 'authexpired',授权过期
     *
     * @param string $status    状态码, 只允许小写
     * @return \St\Response\Ajax
     * @throws \Exception 非法状态码将抛出异常
     */
    public function setStatus($status)
    {
        if (!in_array($status, $this->statusArr)) {
            throw new \Exception('未知状态码:' . htmlentities($status), 1);
        }

        $this->status = $status;
        return $this;
    }

    /**
     * 设置 错误内容
     *
     * @param string $errorMsg  错误内容
     * @return \Cp\Response\Ajax
     */
    public function setErrorMsg($errorMsg)
    {
        $this->errorMsg = trim($errorMsg);
        return $this;
    }

    /**
     * 设置 错误码
     *
     * @param int $errorCode 错误码
     * @return \Cp\Response\Ajax
     */
    public function setErrorCode($errorCode)
    {
        $this->errorCode = $errorCode;
        return $this;
    }

    /**
     * 设置 资源
     *
     * @param array|mixed $result 资源
     * @return \Cp\Response\Ajax
     */
    public function setResult($result)
    {
        $this->result = $result;
        return $this;
    }

    /**
     * JSON 格式的字符串
     *
     * @return string
     */
    public function toJson()
    {
        return json_encode($this->toArray(), \JSON_UNESCAPED_UNICODE);
    }

    /**
     * 固定格式的数组
     *
     * @return array
     */
    public function toArray()
    {
        $result = $this->getResult();

        return array(
            'status'     => $this->getStatus(),
            'error_msg'  => $this->getErrorMsg(),
            'error_code' => $this->getErrorCode(),
            'result'     => ($result instanceof Ajax\ResultList) ? $result->toArray() : $result,
            'timestamp'  => time(),
        );
    }

    /**
     * 发送HTTP头部内容
     *
     * @param string $type 类型, 可选 json/jsonp
     */
    public function sendContentType($type = 'json')
    {
        if ('json' == $type) {
            header('Content-type: application/json; charset=utf-8');
        }
        elseif ('jsonp' == $type) {
            header('Content-type: application/javascript; charset=utf-8');
        }
    }

}

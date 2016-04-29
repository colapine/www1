<?php

namespace Track;

use Orm\Base\Model\AbstractModel;

/**
 * 将报错信息格式化并存在起来
 */
class ErrorModel
{
    /**
     * 报错类型,分普通报错 st_error  Top报错 st_top_error
     * @var string
     */
    private $log_type;

    /**
     * 报错码
     * @var int
     */
    private $code = 0;

    /**
     * 报错信息
     * @var string
     */
    private $message = '';

    /**
     * 报错行
     * @var int
     */
    private $line = 0;

    /**
     * 报错页
     * @var string
     */
    private $file = '';

    /**
     * 错误具体运行流程
     * @var array
     */
    private $track = [];

    /**
     * 补充字段
     * @var array
     */
    private $sub_msg = [];

    /**
     * 客户端请求信息
     * @var array
     */
    private $server = [];

    /**
     * 单例
     *
     * @var ErrorModel
     */
    protected static $instance = null;

    /**
     * 需要存储的数据
     * @var array
     */
    protected static $data = [];

    /**
     * 单例模式
     *
     * @return mixed
     */
    public static function getInstance()
    {
        if (null === static::$instance) {
            static::$instance = new static();
        }

        return static::$instance;
    }

    /**
     * 将报错信息写入到elk
     * @param $exception
     */
    public static function send($exception,$server='')
    {
        try {

            $log = self::getInstance()->farmatData($exception,$server);
            /*报错写入elk*/
            \Track\ElkModel::send($log);

        } catch (\Exception $e) {

        }
    }

    public function farmatData($exception,$server='')
    {
        $this->setServer($server);
        if ($exception instanceof \St\Top\Exception) {

            $sub_msg = array(
                'topSubCode' => $exception->getTopSubCode(),
                'topMsg'     => $exception->getTopMsg(),
                'topSubMsg'  => $exception->getTopSubMsg(),
                'topMethod'  => $exception->getTopMethod()
            );

            $this->setLogType('st_error_'.get_class($exception))
                ->setMessage($exception->getMessage())
                ->setCode($exception->getCode())
                ->setFile($exception->getFile())
                ->setLine($exception->getLine())
                ->setTrack($exception->getTrace())
                ->setSubMsg($sub_msg);
        } elseif ($exception instanceof \Exception) {

            $this->setLogType('st_error_'.get_class($exception))
                ->setMessage($exception->getMessage())
                ->setCode($exception->getCode())
                ->setFile($exception->getFile())
                ->setLine($exception->getLine())
                ->setTrack($exception->getTrace());

        } else {
            $this->setLogType('st_error_null_'.get_class($exception));
        }

        return $this->toArray();
    }

    /**
     * @param $log_type
     * @return \Track\ErrorModel
     */
    private function setLogType($log_type)
    {
        $this->log_type = $log_type;

        return $this;
    }

    /**
     * @param $code
     * @return \Track\ErrorModel
     */
    private function setCode($code)
    {
        $this->code = intval($code);

        return $this;
    }

    /**
     * @param $message
     * @return \Track\ErrorModel
     */
    private function setMessage($message)
    {
        $this->message = trim($message);

        return $this;
    }

    /**
     * @param $line
     * @return \Track\ErrorModel
     */
    private function setLine($line)
    {
        $this->line = $line;

        return $this;
    }

    /**
     * @param $file
     * @return \Track\ErrorModel
     */
    private function setFile($file)
    {
        $this->file = $file;

        return $this;
    }

    /**
     * @param $track
     * @return \Track\ErrorModel
     */
    private function setTrack($track)
    {
        $this->track = json_decode(json_encode($track), true);

        return $this;
    }

    /**
     * @param $sub_msg
     * @return \Track\ErrorModel
     */
    private function setSubMsg($sub_msg)
    {
        $this->sub_msg = $sub_msg;

        return $this;
    }

    /**
     * @param $server
     * @return \Track\ErrorModel
     */
    private function setServer($server)
    {
        $this->server = $server;

        return $this;
    }


    public function toArray()
    {
        return array(
            'log_type' => $this->log_type,
            'code'       => $this->code,
            'message'    => $this->message,
            'line'       => $this->line,
            'file'       => $this->file,
            'track'      => $this->track,
            'sub_msg'    => $this->sub_msg,
            'pid'        => getmypid(),
            'shop_id'    => \Bootstrap::getShopId(),
            'server'     => $this->server
        );
    }


}
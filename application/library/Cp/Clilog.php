<?php

namespace Cp;

class Clilog
{

    /**
     * 单例
     *
     * @var Clilog
     */
    protected static $instance = null;

    /**
     * 已经连接的Redis
     * @var Redis
     */
    protected $redis = null;

    /**
     * 进程ID
     * @var int
     */
    protected $pid = 0;

    /**
     * 今天
     * @var string
     */
    protected $day = '';

    /**
     * 禁用 echo 直接输出
     *
     * @var boolean
     */
    protected $disable = false;

    public function __construct()
    {
        $this->day   = date('Ymd');
        $this->redis = \Bootstrap::getRedis();

        try {
            $this->pid     = getmypid();
            $this->disable = \Yaf\Application::app()->getDispatcher()->getRequest()->isCli() ? false : true;
        }
        catch (\Exception $exc) {
            $this->pid     = 0;
            $this->disable = true;
        }
    }

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
     * 输出日志
     *
     * @param string $log
     * @param string $name
     * @return boolean
     */
    public static function exportLog($log, $name = 'cli')
    {
        return self::getInstance()->exportLogDo($log, $name);
    }

    /**
     * 输出日志
     *
     * @param string $log
     * @param string $name
     * @return boolean
     */
    public function exportLogDo($log, $name = 'cli')
    {
        if (!$this->disable) {
            echo $log, PHP_EOL;
        }

        if (empty($name) or empty($log)) {
            return true;
        }

        $key      = 'clilog:' . $name . ':' . $this->day;
        $keyNames = 'clilog:names:' . $this->day;

        $data = [
            'time'    => time(),
            'pid'     => $this->pid,
            'name'    => $name,
            'content' => $log,
        ];

        if (null === $this->redis) {
            $this->redis = \Bootstrap::getRedis();
        }

        try {
            $len = $this->redis->lPush($key, json_encode($data));
            if (1 == $len) {
                $this->redis->expire($key, 86400 * 3);
                $this->redis->sAdd($keyNames, $name);
                $this->redis->expire($keyNames, 86400 * 3);
            }
            else if (100 < $len) {
                /* 30% 的概率, 裁剪日志 */
                if (3 > rand(0, 10)) {
                    $this->redis->ltrim($key, 0, 99);
                }
            }
        }
        catch (\Exception $exc) {
            return false;
        }
    }

    /**
     * 强制不直接 echo 出日志
     */
    public function disableShow()
    {
        if(!\Bootstrap::isDevelop()){
            $this->disable = true;
        }
    }

}

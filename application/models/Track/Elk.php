<?php

namespace Track;

use Orm\Base\Model\AbstractModel;

/**
 * 将日志输出到elk日志套件
 */
class ElkModel
{

    /**
     * 单例
     *
     * @var ElkModel
     */
    protected static $instance = null;

    /**
     * 是否开启写入
     * @var bool
     */
    protected $isAction = true;

    /**
     * 索引名称关键字
     * 由助手定义好的,存储业务级报错的索引
     * @var string
     */
    protected $data_type = 'soft';

    /**
     * 写入到redis的数据
     * @return bool
     */
    protected $data = [];

    /**
     *
     */
    protected $queunName = 'logstash';


    /**
     * redis
     * @return \Redis|null
     */
    protected $redis = null;

    /**
     * application 的配置参数
     * @var \Yaf\Config\Ini
     */
    protected $config;

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

    public function __construct()
    {
        $this->config = \Bootstrap::getConfig();
        $isactive     = $this->config->get('elk.isactive');


        if (!$isactive) {
            return false;
        } else {
            $this->isactive = true;
        }
        $this->data['type'] = $this->data_type;

        $this->initConf();
        $this->initRedis();

        return true;

    }

    /**
     * 初始化公共参数
     */
    protected function initConf()
    {
        $data['type'] = $this->data_type;


        $this->data = $data;
    }

    /**
     * 初始化redis连接
     * @return bool
     */
    protected function initRedis()
    {
        $elkredis = $this->config->get('elk.redis');

        $redis   = new \Redis();
        $redis->connect($elkredis->get('host'), $elkredis->get('port'));

        if ($elkredis->get('db')) {
            $redis->select($elkredis->get('db'));
        }

        $this->redis = $redis;

        return true;
    }


    public static function send($data)
    {
        self::getInstance()->sendToElk($data);
    }


    public function sendToElk($data)
    {
        if(!is_array($data)){
            return false;
        }

        try{
            $this->data = array_merge($data,$this->data);

            $this->redis->lpush($this->queunName, json_encode($this->data));


        }catch (\Exception $e){

        }
        return true;
    }

}
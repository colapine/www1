<?php

namespace Cp\Counter;

/**
 *
 */
abstract class CountAbstract
{

    /**
     * 默认的保存时长
     * 2851200:33天
     *
     * @var int
     */
    protected $ttl = 2851200;

    /**
     * 键前缀
     * @var string
     */
    protected $keyPre = 'counter:def:';

    /**
     * @var \St\Redis
     */
    protected $redis = null;

    public function __construct()
    {
        $this->init();
    }

    public function init()
    {
        $this->redis = $this->getRedis();
        return true;
    }

    /**
     * 键名
     * @param string $format 时间格式
     * @return string
     */
    public function getKey($format = 'Ymd')
    {
        return $this->keyPre . date($format);
    }

    /**
     * 键名.失败的
     * @param string $format 时间格式
     * @return string
     */
    public function getKeyError($format = 'Ymd')
    {
        return $this->keyPre . 'error:' . date($format);
    }

    /**
     * 获取已连接的Redis
     *
     * @staticvar \St\Redis $redis
     * @return \St\Redis
     */
    public function getRedis()
    {
        static $redis = null;

        if (null == $redis) {
            $redis = \Bootstrap::getRedis();
        }

        return $redis;
    }

    /**
     * 计数
     *
     * @param string $fieldName 字段名称
     */
    public function hIncry($fieldName)
    {
        static $exists = [];

        $keyYmd   = $this->getKey('Ymd');
        $keyYmdHi = $this->getKey('YmdHi');
        $field    = trim($fieldName);

        if (!isset($exists[$keyYmd])) {
            $exists[$keyYmd] = $this->redis->exists($keyYmd);
        }

        if (!isset($exists[$keyYmdHi])) {
            $exists[$keyYmdHi] = $this->redis->exists($keyYmdHi);
        }

        $this->redis->hIncrBy($keyYmd, $field, 1);
        $this->redis->hIncrBy($keyYmdHi, $field, 1);

        if (!$exists[$keyYmd]) {
            $this->redis->expire($keyYmd, $this->ttl);
        }

        if (!$exists[$keyYmdHi]) {
            $this->redis->expire($keyYmdHi, $this->ttl);
        }
    }

    /**
     * 计数.失败的
     *
     * @param string $fieldName 字段名称
     */
    public function hIncryError($fieldName)
    {
        static $exists = [];

        $keyYmd   = $this->getKeyError('Ymd');
        $keyYmdHi = $this->getKeyError('YmdHi');
        $field    = trim($fieldName);

        if (!isset($exists[$keyYmd])) {
            $exists[$keyYmd] = $this->redis->exists($keyYmd);
        }

        if (!isset($exists[$keyYmdHi])) {
            $exists[$keyYmdHi] = $this->redis->exists($keyYmdHi);
        }

        $this->redis->hIncrBy($keyYmd, $field, 1);
        $this->redis->hIncrBy($keyYmdHi, $field, 1);

        if (!$exists[$keyYmd]) {
            $this->redis->expire($keyYmd, $this->ttl);
        }

        if (!$exists[$keyYmdHi]) {
            $this->redis->expire($keyYmdHi, $this->ttl);
        }
    }

}

<?php

namespace Cp\Sms;

class Adapter
{
    /**
     * 驱动
     * @var \St\Sms\Driver\Gd | null
     */
    protected $driver = null;
    protected $result = array();


    public function __construct($driverName, $config)
    {
        $this->createDriver($driverName, $config);
    }

    /**
     * 设置驱动器
     *
     * @param string $driverName 驱动器名称
     * @throws \Exception Undefined driver
     * @return \St\Sms\Driver\Gd
     */
    public function createDriver($driverName, $config)
    {
        $className = '\\St\\Sms\\Driver\\' . trim(ucfirst(strtolower($driverName)));
        if (!class_exists($className)) {
            throw new \Exception('Undefined driver');
        }

        $this->driver = new $className($config);
    }

    /**
     * 获取驱动
     *
     * @return \St\Sms\Driver\Gd|null
     */
    public function getDriver()
    {
        return $this->driver;
    }

    /**
     * 发送下行消息
     */
    public function send($desMobile,$content)
    {
        return $this->driver->send($desMobile,$content);
    }


}

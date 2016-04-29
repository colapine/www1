<?php

namespace Cp\Sms\Driver;

/**
 * Oauth 驱动器接口
 *
 * @author ghost
 */
interface DriverInterface
{
    public function __construct($config);
    /**
     * 发送下行请求
     */
    public function send($desMobile,$content);


}

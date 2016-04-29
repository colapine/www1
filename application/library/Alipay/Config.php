<?php

namespace Alipay;

/**
 * 支付宝接口的配置类
 *
 * @author ghost
 */
class Config
{

    /**
     * 开发者ID
     * @var string
     */
    protected $partner = '';

    /**
     * 安全检验码
     * @var string
     */
    protected $key = '';

    /**
     * 卖家账户
     * @var string
     */
    protected $sellerEmail = '';

    /**
     * 签名方法
     * @var string
     */
    protected $signType = 'MD5';

    /**
     * 访问模式, 根据自己的服务器是否支持ssl访问
     * 支持选择https, 不支持请选择http
     *
     * @var string
     */
    protected $transport = 'http';

    /**
     * 证书名称
     * @var string
     */
    protected $pemName = 'cacert';

    /**
     * 证书名称, 通过 pemName 来拼接
     *
     * @var string
     */
    protected $pemPath = '';

    /**
     * 异步通知的URL
     *
     * @var string
     */
    protected $notifyUrl = '';

    /**
     * 同步回调的URL
     *
     * @var string
     */
    protected $returnUrl = '';

    /**
     * HTTP形式消息验证地址
     * @var string
     */
    protected $verifyUrlHttp = 'http://notify.alipay.com/trade/notify_query.do?';

    /**
     * HTTPS形式消息验证地址
     * @var string
     */
    protected $verifyUrlHttps = 'https://mapi.alipay.com/gateway.do?service=notify_verify&';

    /**
     * 是否强制验证支付宝的消息是否真实, 为了安全, 建议开启
     * @var int
     */
    protected $verifyNotify = 0;

    /**
     * @param string $name
     */
    public function __construct($name = 'direct')
    {
        $yafConf = new \Yaf\Config\Ini(\APPLICATION_PATH . '/conf/alipay.ini', \Yaf\Application::app()->environ());
        $data    = $yafConf->get($name)->toArray();

        foreach ($data as $key => $value) {
            $method = 'set' . $key;
            if (method_exists($this, 'set' . $key)) {
                $this->$method($value);
            }
        }
    }

    /**
     * 开发者ID
     * @return string
     */
    public function getPartner()
    {
        return $this->partner;
    }

    /**
     * 安全检验码
     * @return string
     */
    public function getKey()
    {
        return $this->key;
    }

    /**
     * 获取 卖家账户
     *
     * @return string
     */
    public function getSellerEmail()
    {
        return $this->sellerEmail;
    }

    /**
     * 签名方法
     * @return string
     */
    public function getSignType()
    {
        return $this->signType;
    }

    /**
     * 访问模式, 根据自己的服务器是否支持ssl访问
     * 支持选择https, 不支持请选择http
     *
     * @return string
     */
    public function getTransport()
    {
        return $this->transport;
    }

    /**
     * 证书名称
     * @return string
     */
    public function getPemName()
    {
        return $this->pemName;
    }

    /**
     * 证书的物理路径
     *
     * @return string
     */
    public function getPemPath()
    {
        return __DIR__ . '/' . $this->pemName . '.pem';
    }

    /**
     * 获取 异步通知的URL
     *
     * @return string
     */
    public function getNotifyUrl()
    {
        return $this->notifyUrl;
    }

    /**
     * 获取 同步回调的URL
     *
     * @return string
     */
    public function getReturnUrl()
    {
        return $this->returnUrl;
    }

    /**
     * 开发者ID
     *
     * @param string $partner
     * @return \Alipay\Config
     */
    public function setPartner($partner)
    {
        $this->partner = trim($partner);
        return $this;
    }

    /**
     * 开发者ID
     * @param string $key
     * @return \Alipay\Config
     */
    public function setKey($key)
    {
        $this->key = trim($key);
        return $this;
    }

    /**
     * 设置 卖家账户
     *
     * @param string $sellerEmail
     * @return \Alipay\Config
     */
    public function setSellerEmail($sellerEmail)
    {
        $this->sellerEmail = trim($sellerEmail);
        return $this;
    }

    /**
     * 签名方法
     * @param string $signType
     * @return \Alipay\Config
     */
    public function setSignType($signType)
    {
        $this->signType = strtoupper(trim($signType));
        return $this;
    }

    /**
     * 访问模式, 根据自己的服务器是否支持ssl访问
     * 支持选择https, 不支持请选择http
     *
     * @param string $transport
     * @return \Alipay\Config
     */
    public function setTransport($transport)
    {
        $this->transport = strtolower($transport) == 'http' ? 'http' : 'https';
        return $this;
    }

    /**
     * 证书名称
     * @return \Alipay\Config
     */
    public function setPemName($pemName)
    {
        $pemName = trim($pemName);

        if (empty($pemName)) {
            return $this;
        }

        $this->pemName = $pemName;

        return $this;
    }

    /**
     * 设置 异步通知的URL
     *
     * @param string $notifyUrl
     * @return \Alipay\Config
     */
    public function setNotifyUrl($notifyUrl)
    {
        $this->notifyUrl = $notifyUrl;
        return $this;
    }

    /**
     * 设置 同步回调的URL
     *
     * @param string $returnUrl
     * @return \Alipay\Config
     */
    public function setReturnUrl($returnUrl)
    {
        $this->returnUrl = $returnUrl;
        return $this;
    }

    public function getVerifyUrlHttp()
    {
        return $this->verifyUrlHttp;
    }

    public function getVerifyUrlHttps()
    {
        return $this->verifyUrlHttps;
    }

    public function setVerifyUrlHttp($verifyUrlHttp)
    {
        $this->verifyUrlHttp = $verifyUrlHttp;
        return $this;
    }

    public function setVerifyUrlHttps($verifyUrlHttps)
    {
        $this->verifyUrlHttps = $verifyUrlHttps;
        return $this;
    }

    public function getVerifyNotify()
    {
        return $this->verifyNotify;
    }

    public function setVerifyNotify($verifyNotify)
    {
        $this->verifyNotify = $verifyNotify;
        return $this;
    }

}

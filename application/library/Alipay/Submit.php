<?php

namespace Alipay;

/**
 * 构造支付宝 接口表单类
 *
 * @author ghost
 */
class Submit
{

    /**
     * 请求的URL
     * @var string
     */
    protected $url = '';

    /**
     * 证书名称
     * @var string
     */
    protected $pemPath = '';

    /**
     * 请求的方法
     * @var string
     */
    protected $method = 'GET';

    /**
     * 附加参数
     * @var array
     */
    protected $params = [];

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
     * @var Config
     */
    protected $configObj = null;

    /**
     * 支付宝网关
     * @var string
     */
    protected $alipayGateway = 'https://mapi.alipay.com/gateway.do?_input_charset=utf-8';

    public function setConfig(Config $config)
    {
        $this->configObj = $config;
        $this->setPartner($config->getPartner());
        $this->setKey($config->getKey());
        $this->setPemPath($config->getPemPath());
        $this->setSignType($config->getSignType());
        $this->setTransport($config->getTransport());
        $this->setNotifyUrl($config->getNotifyUrl());
        $this->setReturnUrl($config->getReturnUrl());
        $this->setSellerEmail($config->getSellerEmail());
    }

    public function getUrl()
    {
        return $this->url;
    }

    public function getPemPath()
    {
        return $this->pemPath;
    }

    public function getMethod()
    {
        return $this->method;
    }

    public function getParams()
    {
        return $this->params;
    }

    public function getPartner()
    {
        return $this->partner;
    }

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

    public function getSignType()
    {
        return $this->signType;
    }

    public function getTransport()
    {
        return $this->transport;
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

    public function setUrl($url)
    {
        $this->url = $url;
        return $this;
    }

    public function setPemPath($pemPath)
    {
        $this->pemPath = $pemPath;
        return $this;
    }

    public function setMethod($method)
    {
        $this->method = $method;
        return $this;
    }

    public function setParams($params)
    {
        $this->params = $params;
        return $this;
    }

    public function setPartner($partner)
    {
        $this->partner = $partner;
        return $this;
    }

    public function setKey($key)
    {
        $this->key = $key;
        return $this;
    }

    /**
     * 设置 卖家账户
     *
     * @param string $sellerEmail
     * @return Submit
     */
    public function setSellerEmail($sellerEmail)
    {
        $this->sellerEmail = trim($sellerEmail);
        return $this;
    }

    /**
     *
     * @param string $signType
     * @return \Alipay\Submit
     */
    public function setSignType($signType)
    {
        $this->signType = $signType;
        return $this;
    }

    public function setTransport($transport)
    {
        $this->transport = $transport;
        return $this;
    }

    /**
     * 设置 异步通知的URL
     *
     * @param string $notifyUrl
     * @return \Alipay\Submit
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
     * @return \Alipay\Submit
     */
    public function setReturnUrl($returnUrl)
    {
        $this->returnUrl = $returnUrl;
        return $this;
    }

    /**
     * 生成签名结果
     * @param string $params 已排序要签名的数组
     * @return 签名结果字符串
     */
    public function buildRequestMysign($params)
    {
        $str = Tool::createLinkstring($params);
        return 'MD5' == $this->getSignType() ? Tool::md5Sign($str, $this->getKey()) : '';
    }

    /**
     * 公用参数
     * @return array
     */
    public function getPubParams()
    {
        $data = [
            'service'        => 'create_direct_pay_by_user',
            'payment_type'   => '1',
            '_input_charset' => 'utf-8',
            'partner'        => $this->getPartner(),
            'notify_url'     => $this->getNotifyUrl(),
            'return_url'     => $this->getReturnUrl(),
            'seller_email'   => $this->getSellerEmail(),
        ];

        return $data;
    }

    /**
     * @return array
     */
    public function buildRequestParams($params)
    {
        //除去待签名参数数组中的空值和签名参数
        $data = Tool::paramsFilter(array_merge($params, $this->getPubParams()));

        //生成签名结果
        $mysign = $this->buildRequestMysign($data);

        //签名结果与签名方式加入请求提交参数组中
        $data['sign']      = $mysign;
        $data['sign_type'] = strtoupper($this->getSignType());

        return $data;
    }

    /**
     * 建立请求, 以表单HTML形式构造
     *
     * @param $params 请求参数数组
     * @return string 提交表单HTML文本
     */
    function buildRequestForm($params)
    {
        $str = '<form id="alipaysubmit" name="alipaysubmit" '
                . 'action="' . $this->alipayGateway . '" '
                . 'method="' . $this->getMethod() . '" >' . PHP_EOL;


        foreach ($this->buildRequestParams($params) as $key => $value) {
            $str .= ' <input type="hidden" name="' . $key . '" value="' . $value . '" /> <br />' . PHP_EOL;
        }

        //submit按钮控件请不要含有name属性
        $str .= "<input type='submit' value='确定'></form>";
        $str .= '<script>document.forms["alipaysubmit"].submit();</script>' . PHP_EOL;

        return $str;
    }

}

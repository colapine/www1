<?php

namespace Alipay;

/**
 * 支付宝接口的请求客户端类
 * 因为涉及到自定义的证书,
 * 所以, 没有直接用之前存在的 \St\Http 来请求淘宝接口
 *
 * @author ghost
 */
class Http
{

    /**
     * 请求的URL
     * @var Config
     */
    protected $config = null;

    public function __construct(Config $config = null)
    {
        if ($config instanceof Config) {
            $this->setConfig($config);
        }
    }

    /**
     * 设置 配置类
     * @param Config $config
     * @return \Alipay\Http
     */
    public function setConfig(Config $config)
    {
        $this->config = $config;
        return $this;
    }

    /**
     * 验证 notifyId 是否是支付宝发起的
     *
     * 注意:
     * invalid 命令参数不对 出现这个错误, 请检测返回处理中partner和key是否为空
     * true 返回正确信息
     * false 请检查防火墙或者是服务器阻止端口问题以及验证时间是否超过一分钟
     *
     * @param string $notifyId
     * @return boolean
     */
    public function veryfyNotify($notifyId)
    {
        $config = $this->config;
        $url    = ('https' == $config->getTransport()) ? $config->getVerifyUrlHttps() : $config->getVerifyUrlHttp();
        $url .= "partner={$config->getPartner()}&notify_id={$notifyId}";

        $html = $this->getHttpResponseGET($url);
        return ('true' == $html) ? true : false;
    }

    /**
     * 远程获取数据，GET模式
     * @param $url 指定URL完整路径地址
     * @return 远程输出的数据
     */
    public function getHttpResponseGET($url)
    {
        $curl = curl_init($url);

        curl_setopt($curl, \CURLOPT_HEADER, 0);
        curl_setopt($curl, \CURLOPT_RETURNTRANSFER, 1); // 显示输出结果
        curl_setopt($curl, \CURLOPT_SSL_VERIFYPEER, true);
        curl_setopt($curl, \CURLOPT_SSL_VERIFYHOST, 2);
        curl_setopt($curl, \CURLOPT_CAINFO, $this->config->getPemPath());

        $responseText = curl_exec($curl);
        curl_close($curl);

        return $responseText;
    }

}

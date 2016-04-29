<?php

namespace Alipay;

/**
 * 支付宝接口的一些常用工具函数
 *
 * @author ghost
 */
class Tool
{

    /**
     * 对数组进行排序
     *
     * @param array $params
     * @return array
     */
    public static function ascSort($params)
    {
        ksort($params);
        reset($params);

        return $params;
    }

    /**
     * 用 md5 哈希来签名
     *
     * @param string $prestr 签名前的字符串
     * @param string $key    私钥
     * @return string 签名结果
     */
    public static function md5Sign($prestr, $key)
    {
        return md5($prestr . $key);
    }

    /**
     * 验证签名
     *
     * @param string  $prestr 需要签名的字符串
     * @param string  $sign   签名结果
     * @param string  $key    私钥
     * return boolean
     */
    public static function md5Verify($prestr, $sign, $key)
    {
        $prestr = $prestr . $key;
        $mysgin = md5($prestr);

        return($mysgin == $sign) ? true : false;
    }

    /**
     * 除去数组中的空值和签名参数
     * @param array $params 签名参数组
     * @return array 去掉空值与签名参数后的新签名参数组
     */
    public static function paramsFilter($params)
    {
        $data = [];

        if (isset($params['sign'])) {
            unset($params['sign']);
        }

        if (isset($params['sign_type'])) {
            unset($params['sign_type']);
        }

        foreach ($params as $key => $value) {
            if ($value == '') {
                continue;
            }

            $data[$key] = $value;
        }

        ksort($data);
        reset($data);

        return $data;
    }

    /**
     * 把数组所有元素，按照“参数=参数值”的模式用“&”字符拼接成字符串
     * @param array $params 需要拼接的数组
     * @return string 拼接完成以后的字符串
     */
    public static function createLinkstringUrlencode($params)
    {
        return http_build_query($params);
    }

    /**
     * 把数组所有元素，按照“参数=参数值”的模式用“&”字符拼接成字符串
     *
     * 注意, 没有进行 UrlEncode
     *
     * @param array $params 需要拼接的数组
     * @return string 拼接完成以后的字符串
     */
    public static function createLinkstring($params)
    {
        $str = '';

        foreach ($params as $key => $value) {
            $str .= "$key=$value&";
        }

        return trim($str, '&');
    }

}

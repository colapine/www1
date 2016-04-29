<?php

namespace Alipay\Response;

/**
 * 通知的接口
 */
interface DirectInterface
{

    /**
     * @return array
     */
    public function toArray();

    /**
     * 返回 掉去前缀后的商家交易码
     * @return int|null
     */
    public function queryOutTradeNo();
}

<?php

namespace Alipay\Response;

use Orm\Base\Model\AbstractModel;

/**
 * 支付宝 即时到账的通知及请求体
 */
class DirectReturn extends AbstractModel implements DirectInterface
{

    /**
     *
     * @var string
     */
    protected $body = '';

    /**
     *
     * @var string
     */
    protected $buyerEmail = '';

    /**
     *
     * @var string
     */
    protected $buyerId = '';

    /**
     *
     * @var string
     */
    protected $exterface = '';

    /**
     *
     * @var string
     */
    protected $isSuccess = '';

    /**
     *
     * @var string
     */
    protected $notifyId = '';

    /**
     *
     * @var string
     */
    protected $notifyTime = '';

    /**
     *
     * @var string
     */
    protected $notifyType = '';

    /**
     *
     * @var string
     */
    protected $outTradeNo = '';

    /**
     *
     * @var string
     */
    protected $paymentType = '';

    /**
     *
     * @var string
     */
    protected $sellerEmail = '';

    /**
     *
     * @var string
     */
    protected $sellerId = '';

    /**
     *
     * @var string
     */
    protected $subject = '';

    /**
     *
     * @var string
     */
    protected $totalFee = '';

    /**
     *
     * @var string
     */
    protected $tradeNo = '';

    /**
     *
     * @var string
     */
    protected $tradeStatus = '';

    /**
     *
     * @var string
     */
    protected $sign = '';

    /**
     *
     * @var string
     */
    protected $signType = '';

    public function getBody()
    {
        return $this->body;
    }

    public function getBuyerEmail()
    {
        return $this->buyerEmail;
    }

    public function getBuyerId()
    {
        return $this->buyerId;
    }

    public function getExterface()
    {
        return $this->exterface;
    }

    public function getIsSuccess()
    {
        return $this->isSuccess;
    }

    public function getNotifyId()
    {
        return $this->notifyId;
    }

    public function getNotifyTime()
    {
        return $this->notifyTime;
    }

    public function getNotifyType()
    {
        return $this->notifyType;
    }

    public function getOutTradeNo()
    {
        return $this->outTradeNo;
    }

    public function getPaymentType()
    {
        return $this->paymentType;
    }

    public function getSellerEmail()
    {
        return $this->sellerEmail;
    }

    public function getSellerId()
    {
        return $this->sellerId;
    }

    public function getSubject()
    {
        return $this->subject;
    }

    public function getTotalFee()
    {
        return $this->totalFee;
    }

    public function getTradeNo()
    {
        return $this->tradeNo;
    }

    public function getTradeStatus()
    {
        return $this->tradeStatus;
    }

    public function getSign()
    {
        return $this->sign;
    }

    public function getSignType()
    {
        return $this->signType;
    }

    public function setBody($body)
    {
        $this->body = $body;
        return $this;
    }

    public function setBuyerEmail($buyerEmail)
    {
        $this->buyerEmail = $buyerEmail;
        return $this;
    }

    public function setBuyerId($buyerId)
    {
        $this->buyerId = $buyerId;
        return $this;
    }

    public function setExterface($exterface)
    {
        $this->exterface = $exterface;
        return $this;
    }

    public function setIsSuccess($isSuccess)
    {
        $this->isSuccess = $isSuccess;
        return $this;
    }

    public function setNotifyId($notifyId)
    {
        $this->notifyId = $notifyId;
        return $this;
    }

    public function setNotifyTime($notifyTime)
    {
        $this->notifyTime = $notifyTime;
        return $this;
    }

    public function setNotifyType($notifyType)
    {
        $this->notifyType = $notifyType;
        return $this;
    }

    public function setOutTradeNo($outTradeNo)
    {
        $this->outTradeNo = $outTradeNo;
        return $this;
    }

    public function setPaymentType($paymentType)
    {
        $this->paymentType = $paymentType;
        return $this;
    }

    public function setSellerEmail($sellerEmail)
    {
        $this->sellerEmail = $sellerEmail;
        return $this;
    }

    public function setSellerId($sellerId)
    {
        $this->sellerId = $sellerId;
        return $this;
    }

    public function setSubject($subject)
    {
        $this->subject = $subject;
        return $this;
    }

    public function setTotalFee($totalFee)
    {
        $this->totalFee = $totalFee;
        return $this;
    }

    public function setTradeNo($tradeNo)
    {
        $this->tradeNo = $tradeNo;
        return $this;
    }

    public function setTradeStatus($tradeStatus)
    {
        $this->tradeStatus = $tradeStatus;
        return $this;
    }

    public function setSign($sign)
    {
        $this->sign = $sign;
        return $this;
    }

    public function setSignType($signType)
    {
        $this->signType = $signType;
        return $this;
    }

    public function toArray()
    {
        return array(
            'body'         => $this->body,
            'buyer_email'  => $this->buyerEmail,
            'buyer_id'     => $this->buyerId,
            'exterface'    => $this->exterface,
            'is_success'   => $this->isSuccess,
            'notify_id'    => $this->notifyId,
            'notify_time'  => $this->notifyTime,
            'notify_type'  => $this->notifyType,
            'out_trade_no' => $this->outTradeNo,
            'payment_type' => $this->paymentType,
            'seller_email' => $this->sellerEmail,
            'seller_id'    => $this->sellerId,
            'subject'      => $this->subject,
            'total_fee'    => $this->totalFee,
            'trade_no'     => $this->tradeNo,
            'trade_status' => $this->tradeStatus,
            'sign'         => $this->sign,
            'sign_type'    => $this->signType,
        );
    }

    /**
     * 返回 掉去前缀后的商家交易码
     * @return int|null
     */
    public function queryOutTradeNo()
    {
        $data = [];
        if (!preg_match('/\d+/', $this->getOutTradeNo(), $data)) {
            return null;
        }

        return isset($data[0]) ? intval($data[0]) : null;
    }

}

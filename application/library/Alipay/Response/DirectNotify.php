<?php

namespace Alipay\Response;

use Orm\Base\Model\AbstractModel;

/**
 * 支付宝 即时到账的通知及请求体
 */
class DirectNotify extends AbstractModel implements DirectInterface
{

    protected $body             = '';
    protected $buyerEmail       = '';
    protected $buyerId          = '';
    protected $discount         = '';
    protected $gmtCreate        = '';
    protected $gmtPayment       = '';
    protected $isTotalFeeAdjust = '';
    protected $notifyId         = '';
    protected $notifyTime       = '';
    protected $notifyType       = '';
    protected $outTradeNo       = '';
    protected $paymentType      = '';
    protected $price            = '';
    protected $quantity         = '';
    protected $sellerEmail      = '';
    protected $sellerId         = '';
    protected $sign             = '';
    protected $subject          = '';
    protected $totalFee         = '';
    protected $tradeNo          = '';
    protected $tradeStatus      = '';
    protected $useCoupon        = '';

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

    public function getDiscount()
    {
        return $this->discount;
    }

    public function getGmtCreate()
    {
        return $this->gmtCreate;
    }

    public function getGmtPayment()
    {
        return $this->gmtPayment;
    }

    public function getIsTotalFeeAdjust()
    {
        return $this->isTotalFeeAdjust;
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

    public function getPrice()
    {
        return $this->price;
    }

    public function getQuantity()
    {
        return $this->quantity;
    }

    public function getSellerEmail()
    {
        return $this->sellerEmail;
    }

    public function getSellerId()
    {
        return $this->sellerId;
    }

    public function getSign()
    {
        return $this->sign;
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

    public function getUseCoupon()
    {
        return $this->useCoupon;
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

    public function setDiscount($discount)
    {
        $this->discount = $discount;
        return $this;
    }

    public function setGmtCreate($gmtCreate)
    {
        $this->gmtCreate = $gmtCreate;
        return $this;
    }

    public function setGmtPayment($gmtPayment)
    {
        $this->gmtPayment = $gmtPayment;
        return $this;
    }

    public function setIsTotalFeeAdjust($isTotalFeeAdjust)
    {
        $this->isTotalFeeAdjust = $isTotalFeeAdjust;
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

    public function setPrice($price)
    {
        $this->price = $price;
        return $this;
    }

    public function setQuantity($quantity)
    {
        $this->quantity = $quantity;
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

    public function setSign($sign)
    {
        $this->sign = $sign;
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

    public function setUseCoupon($useCoupon)
    {
        $this->useCoupon = $useCoupon;
        return $this;
    }

    public function toArray()
    {
        return [
            'body'                => $this->body,
            'buyer_email'         => $this->buyerEmail,
            'buyer_id'            => $this->buyerId,
            'discount'            => $this->discount,
            'gmt_create'          => $this->gmtCreate,
            'gmt_payment'         => $this->gmtPayment,
            'is_total_fee_adjust' => $this->isTotalFeeAdjust,
            'notify_id'           => $this->notifyId,
            'notify_time'         => $this->notifyTime,
            'notify_type'         => $this->notifyType,
            'out_trade_no'        => $this->outTradeNo,
            'payment_type'        => $this->paymentType,
            'price'               => $this->price,
            'quantity'            => $this->quantity,
            'seller_email'        => $this->sellerEmail,
            'seller_id'           => $this->sellerId,
            'subject'             => $this->subject,
            'total_fee'           => $this->totalFee,
            'trade_no'            => $this->tradeNo,
            'trade_status'        => $this->tradeStatus,
            'use_coupon'          => $this->useCoupon,
        ];
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

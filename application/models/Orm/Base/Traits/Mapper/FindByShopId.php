<?php

namespace Orm\Base\Traits\Mapper;

/**
 * 提供 findByShopId(), fetchByShopId() 的模板:
 */
trait ByShopIdModel
{

    /**
     * 通过卖家ID, 获取数据模型
     *
     * @param string $shopId  卖家ID
     * @return mixed|null
     */
    public function findByShopId($shopId)
    {
        if (empty($shopId)) {
            return null;
        }

        return $this->fetchOne(array('shop_id' => intval($shopId)));
    }

}

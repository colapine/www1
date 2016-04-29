<?php

namespace Orm\Base\Traits;

use Orm\Mapper\Core\ShopModel as ShopMapper;

/**
 * 提供 querShop() 方法
 */
trait QueryShopModel
{

    /**
     * 查询 关联的Shop模型
     *
     * @return \Orm\Core\ShopModel|null
     */
    public function queryShop()
    {
        return ShopMapper::getInstance()->find($this->getShopId());
    }

}

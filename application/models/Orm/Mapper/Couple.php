<?php

namespace Orm\Mapper;

use Orm\Mapper\AbstractModel as mapAbstract;
use Zend\Db\Sql\Expression;

/**
 * 数学模型
 * Class CoupleModel
 * @package Orm\Mapper
 */
class CoupleModel extends mapAbstract
{

    /**
     * 缓存名称
     */
    protected $cacheKey = '';

    /**
     * 缓存有效时间
     *   6个小时
     */
    protected $expire = 21600;


    /**
     * 单例, 所有的子类都必需定义此属性
     *
     * @var CoupleModel
     */
    protected static $instance = null;

    /**
     * 单例接口
     *
     * @return CoupleModel
     */
    public static function getInstance()
    {
        return parent::getInstance();
    }

    /**
     * 映射器对应的数据模型类名
     *
     * @return string
     */
    public function getModelClassName()
    {
        return '\\Orm\\CoupleModel';
    }

    /**
     * 返回 数据库表的主键
     *
     * @return string
     */
    public function getPrimaryKey()
    {
        return 'id';
    }

    /**
     * 映射器对应的数据库表名
     *
     * 注意, 如果涉及到分表, 需要返回分表后的名称
     *
     * @return string
     */
    public function getTableName()
    {
        return $this->getTableNameBase();
    }

    /**
     * 对于有分表的Mapper, 需要自己覆盖此方法
     *
     * @return string 需要分表的基表表名
     */
    public function getTableNameBase()
    {
        return 'couple';
    }

    /**
     * 通过主键获取数据模型
     *
     * @param int $val tid
     *
     * @return \Orm\CoupleModel|null
     */
    public function find($val)
    {
        return $this->fetchOne(array('id' => intval($val)));
    }


    /**
     * 插入数据
     *
     * @param   \Orm\CoupleModel $model
     * @return int
     */
    public function insert(\Orm\CoupleModel $model)
    {
        $model->setCreatetime(time())->setUpdatetime(time());
        return parent::tgInsert($model->toArray());
    }


    /**
     * 更新数据
     *
     * @param   \Orm\CoupleModel $model
     * @return int
     */
    public function update(\Orm\CoupleModel $model)
    {
        $model->setUpdatetime(time());
        $where = array($this->getPrimaryKey() => $model->getId());
        $data  = $model->toArray();

        unset($data[$this->getPrimaryKey()]);

        return parent::tgUpdate($data, $where);
    }

    /**
     * 获取作品列表
     */
    public function getNameList()
    {
        $list = $this->fetchAll();
        $data = [];
        /* @var $v \Orm\CoupleModel*/
        foreach($list as $v){
            $data[$v->getId()] = $v->getName();
        }

        return $data;
    }

    /**
     * 删除数据
     */
    public function delete(\Orm\CoupleModel $model)
    {
        $where = ['id' => $model->getId()];

        return $this->remove($where);
    }


}

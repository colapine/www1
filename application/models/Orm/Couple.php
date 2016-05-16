<?php

namespace Orm;

use Orm\Base\Model\AbstractModel;

/**
 * 数据模型
 * 
 * Table: couple
 */
class CoupleModel extends AbstractModel
{

    /**
     * 
     *
     * @var Int
     */
    protected $id = null;

    /**
     * 
     *
     * @var String
     */
    protected $name = null;

    /**
     * 作品ID
     *
     * @var Int
     */
    protected $worksId = 0;

    /**
     * 介绍
     *
     * @var String
     */
    protected $details = null;

    /**
     * 
     *
     * @var Int
     */
    protected $createtime = null;

    /**
     * 
     *
     * @var Int
     */
    protected $updatetime = null;

    /**
     * 获取 
     *
     * @return Int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * 设置 
     *
     * database: int(11)
     * @param Int $id 
     * @return \Orm\CoupleModel
     */
    public function setId($id)
    {
        $this->id = intval($id);
        return $this;
    }

    /**
     * 获取 
     *
     * @return String
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * 设置 
     *
     * database: varchar(45)
     * @param String $name 
     * @return \Orm\CoupleModel
     */
    public function setName($name)
    {
        $this->name = trim($name);
        return $this;
    }

    /**
     * 获取 作品ID
     *
     * @return Int
     */
    public function getWorksId()
    {
        return $this->worksId;
    }

    /**
     * 设置 作品ID
     *
     * database: int(10) unsigned
     * @param Int $worksId 作品ID
     * @return \Orm\CoupleModel
     */
    public function setWorksId($worksId)
    {
        $this->worksId = abs(intval($worksId));
        return $this;
    }

    /**
     * 获取 介绍
     *
     * @return String
     */
    public function getDetails()
    {
        return $this->details;
    }

    /**
     * 设置 介绍
     *
     * database: varchar(500)
     * @param String $details 介绍
     * @return \Orm\CoupleModel
     */
    public function setDetails($details)
    {
        $this->details = trim($details);
        return $this;
    }

    /**
     * 获取 
     *
     * @return Int
     */
    public function getCreatetime()
    {
        return $this->createtime;
    }

    /**
     * 设置 
     *
     * database: int(10) unsigned
     * @param Int $createtime 
     * @return \Orm\CoupleModel
     */
    public function setCreatetime($createtime)
    {
        $this->createtime = abs(intval($createtime));
        return $this;
    }

    /**
     * 获取 
     *
     * @return Int
     */
    public function getUpdatetime()
    {
        return $this->updatetime;
    }

    /**
     * 设置 
     *
     * database: int(10) unsigned
     * @param Int $updatetime 
     * @return \Orm\CoupleModel
     */
    public function setUpdatetime($updatetime)
    {
        $this->updatetime = abs(intval($updatetime));
        return $this;
    }

    /**
     * @return array
     */
    public function toArray()
    {
        return array(
            'id'         => $this->id,
            'name'       => $this->name,
            'works_id'   => $this->worksId,
            'details'    => $this->details,
            'createtime' => $this->createtime,
            'updatetime' => $this->updatetime,
        );
    }

}

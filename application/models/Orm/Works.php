<?php

namespace Orm;

use Orm\Base\Model\AbstractModel;

/**
 * 数据模型
 * 
 * Table: works
 */
class WorksModel extends AbstractModel
{

    /**
     * 
     *
     * @var Int
     */
    protected $id = null;

    /**
     * 作品名称
     *
     * @var String
     */
    protected $name = null;

    /**
     * 图片
     *
     * @var String
     */
    protected $pics = null;

    /**
     * 
     *
     * @var Int
     */
    protected $language = null;

    /**
     * 作品类型
     *
     * @var String
     */
    protected $type = null;

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
    protected $createtime = 0;

    /**
     * 
     *
     * @var Int
     */
    protected $updatetime = 0;

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
     * @return \Orm\WorksModel
     */
    public function setId($id)
    {
        $this->id = intval($id);
        return $this;
    }

    /**
     * 获取 作品名称
     *
     * @return String
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * 设置 作品名称
     *
     * database: varchar(45)
     * @param String $name 作品名称
     * @return \Orm\WorksModel
     */
    public function setName($name)
    {
        $this->name = trim($name);
        return $this;
    }

    /**
     * 获取 图片
     *
     * @return String
     */
    public function getPics()
    {
        return $this->pics;
    }

    /**
     * 设置 图片
     *
     * database: varchar(100)
     * @param String $pics 图片
     * @return \Orm\WorksModel
     */
    public function setPics($pics)
    {
        $this->pics = trim($pics);
        return $this;
    }

    /**
     * 获取 
     *
     * @return Int
     */
    public function getLanguage()
    {
        return $this->language;
    }

    /**
     * 设置 
     *
     * database: tinyint(1)
     * @param Int $language 
     * @return \Orm\WorksModel
     */
    public function setLanguage($language)
    {
        $this->language = intval($language);
        return $this;
    }

    /**
     * 获取 作品类型
     *
     * @return String
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * 设置 作品类型
     *
     * database: varchar(45)
     * @param String $type 作品类型
     * @return \Orm\WorksModel
     */
    public function setType($type)
    {
        $this->type = trim($type);
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
     * database: varchar(45)
     * @param String $details 介绍
     * @return \Orm\WorksModel
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
     * @return \Orm\WorksModel
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
     * @return \Orm\WorksModel
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
            'pics'       => $this->pics,
            'language'   => $this->language,
            'type'       => $this->type,
            'details'    => $this->details,
            'createtime' => $this->createtime,
            'updatetime' => $this->updatetime,
        );
    }

}

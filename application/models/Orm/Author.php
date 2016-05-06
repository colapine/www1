<?php

namespace Orm;

use Orm\Base\Model\AbstractModel;

/**
 * 数据模型
 * 
 * Table: author
 */
class AuthorModel extends AbstractModel
{

    /**
     * 
     *
     * @var Int
     */
    protected $id = null;

    /**
     * 名字
     *
     * @var String
     */
    protected $name = null;

    /**
     * 别名
     *
     * @var String
     */
    protected $alias = null;

    /**
     * 国家
     *
     * @var Int
     */
    protected $country = 0;

    /**
     * 性别
     *
     * @var Int
     */
    protected $sex = 0;

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
     * @return \Orm\AuthorModel
     */
    public function setId($id)
    {
        $this->id = intval($id);
        return $this;
    }

    /**
     * 获取 名字
     *
     * @return String
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * 设置 名字
     *
     * database: varchar(45)
     * @param String $name 名字
     * @return \Orm\AuthorModel
     */
    public function setName($name)
    {
        $this->name = trim($name);
        return $this;
    }

    /**
     * 获取 别名
     *
     * @return String
     */
    public function getAlias()
    {
        return $this->alias;
    }

    /**
     * 设置 别名
     *
     * database: varchar(50)
     * @param String $alias 别名
     * @return \Orm\AuthorModel
     */
    public function setAlias($alias)
    {
        $this->alias = trim($alias);
        return $this;
    }

    /**
     * 获取 国家
     *
     * @return Int
     */
    public function getCountry()
    {
        return $this->country;
    }

    /**
     * 设置 国家
     *
     * database: tinyint(4) unsigned
     * @param Int $country 国家
     * @return \Orm\AuthorModel
     */
    public function setCountry($country)
    {
        $this->country = abs(intval($country));
        return $this;
    }

    /**
     * 获取 性别
     *
     * @return Int
     */
    public function getSex()
    {
        return $this->sex;
    }

    /**
     * 设置 性别
     *
     * database: tinyint(1) unsigned
     * @param Int $sex 性别
     * @return \Orm\AuthorModel
     */
    public function setSex($sex)
    {
        $this->sex = abs(intval($sex));
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
     * @return \Orm\AuthorModel
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
     * @return \Orm\AuthorModel
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
            'alias'      => $this->alias,
            'country'    => $this->country,
            'sex'        => $this->sex,
            'createtime' => $this->createtime,
            'updatetime' => $this->updatetime,
        );
    }

}

<?php

namespace Orm;

use Orm\Base\Model\AbstractModel;

/**
 * 数据模型
 * 
 * Table: config
 */
class ConfigModel extends AbstractModel
{

    /**
     * 
     *
     * @var Int
     */
    protected $id = 0;

    /**
     * 类别名称
     *
     * @var String
     */
    protected $typename = null;

    /**
     * 类别ID
     *
     * @var Int
     */
    protected $typeid = 0;

    /**
     * 具体配置信息
     *
     * @var String
     */
    protected $json = null;

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
     * database: tinyint(2) unsigned
     * @param Int $id 
     * @return \Orm\ConfigModel
     */
    public function setId($id)
    {
        $this->id = abs(intval($id));
        return $this;
    }

    /**
     * 获取 类别名称
     *
     * @return String
     */
    public function getTypename()
    {
        return $this->typename;
    }

    /**
     * 设置 类别名称
     *
     * database: varchar(45)
     * @param String $typename 类别名称
     * @return \Orm\ConfigModel
     */
    public function setTypename($typename)
    {
        $this->typename = trim($typename);
        return $this;
    }

    /**
     * 获取 类别ID
     *
     * @return Int
     */
    public function getTypeid()
    {
        return $this->typeid;
    }

    /**
     * 设置 类别ID
     *
     * database: tinyint(2) unsigned
     * @param Int $typeid 类别ID
     * @return \Orm\ConfigModel
     */
    public function setTypeid($typeid)
    {
        $this->typeid = abs(intval($typeid));
        return $this;
    }

    /**
     * 获取 具体配置信息
     *
     * @return String
     */
    public function getJson()
    {
        return $this->json;
    }

    /**
     * 设置 具体配置信息
     *
     * database: varchar(2000)
     * @param String $json 具体配置信息
     * @return \Orm\ConfigModel
     */
    public function setJson($json)
    {
        $this->json = trim($json);
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
     * @return \Orm\ConfigModel
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
     * @return \Orm\ConfigModel
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
            'typename'   => $this->typename,
            'typeid'     => $this->typeid,
            'json'       => $this->json,
            'createtime' => $this->createtime,
            'updatetime' => $this->updatetime,
        );
    }

}

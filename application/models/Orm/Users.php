<?php

namespace Orm;

use Orm\Base\Model\AbstractModel;

/**
 * 数据模型
 * 
 * Table: users
 */
class UsersModel extends AbstractModel
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
    protected $email = null;

    /**
     * 
     *
     * @var String
     */
    protected $usernick = null;

    /**
     * 
     *
     * @var String
     */
    protected $password = null;

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
     * database: bigint(20) unsigned
     * @param Int $id 
     * @return \Orm\UsersModel
     */
    public function setId($id)
    {
        $this->id = abs(intval($id));
        return $this;
    }

    /**
     * 获取 
     *
     * @return String
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * 设置 
     *
     * database: varchar(45)
     * @param String $email 
     * @return \Orm\UsersModel
     */
    public function setEmail($email)
    {
        $this->email = trim($email);
        return $this;
    }

    /**
     * 获取 
     *
     * @return String
     */
    public function getUsernick()
    {
        return $this->usernick;
    }

    /**
     * 设置 
     *
     * database: varchar(45)
     * @param String $usernick 
     * @return \Orm\UsersModel
     */
    public function setUsernick($usernick)
    {
        $this->usernick = trim($usernick);
        return $this;
    }

    /**
     * 获取 
     *
     * @return String
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * 设置 
     *
     * database: char(48)
     * @param String $password 
     * @return \Orm\UsersModel
     */
    public function setPassword($password)
    {
        $this->password = trim($password);
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
     * database: int(11)
     * @param Int $createtime 
     * @return \Orm\UsersModel
     */
    public function setCreatetime($createtime)
    {
        $this->createtime = intval($createtime);
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
     * database: int(11)
     * @param Int $updatetime 
     * @return \Orm\UsersModel
     */
    public function setUpdatetime($updatetime)
    {
        $this->updatetime = intval($updatetime);
        return $this;
    }

    /**
     * @return array
     */
    public function toArray()
    {
        return array(
            'id'         => $this->id,
            'email'      => $this->email,
            'usernick'   => $this->usernick,
            'password'   => $this->password,
            'createtime' => $this->createtime,
            'updatetime' => $this->updatetime,
        );
    }

}

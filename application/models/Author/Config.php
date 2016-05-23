<?php
/**
 * Created by PhpStorm.
 * User: abu
 * Date: 16/5/15
 * Time: 下午10:08
 */

namespace Author;

use Orm\Mapper\ConfigModel as MapConfig;
use Orm\Mapper\WorksModel  as MapWorks;

class ConfigModel
{
    /**
     * 单例
     *
     * @var ConfigModel
     */
    protected static $instance = null;

    /**
     * 单例接口
     *
     * @return ConfigModel
     */
    public static function getInstance()
    {
        if (null === static::$instance) {
            static::$instance = new static();
        }

        return static::$instance;
    }

    public function __construct()
    {
    }

    public function init()
    {
        return true;
    }

    public function getSetting()
    {
        $data=[];
        $data['works'] = MapWorks::getInstance()->getNameList();
        $config = MapConfig::getInstance()->getList();


        return array_merge($data,$config);
    }

}
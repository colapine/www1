<?php
/**
 * Created by PhpStorm.
 * User: abu
 * Date: 16/5/15
 * Time: 下午10:08
 */

namespace Books;

use Orm\Mapper\AuthorModel as MapAuthor;
use Orm\Mapper\WorksModel as MapWorks;
use Orm\Mapper\CoupleModel as MapCouple;
use Orm\Mapper\ConfigModel as MapConfig;

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
        $cf = [];

        $cf['authors'] = MapAuthor::getInstance()->getNameList();
        $cf['workses']  = MapWorks::getInstance()->getNameList();
        $cf['couples'] = MapCouple::getInstance()->getNameList();

        $config = MapConfig::getInstance()->getList();

        return array_merge($cf,$config);
    }

}
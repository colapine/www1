<?php

use Yaf\Application;
use Yaf\Bootstrap_Abstract;
use Yaf\Dispatcher;
use Yaf\Registry;
use Yaf\Session;
use Yaf\Config\Ini;
use Yaf\Loader;
use Cp\Route as CpRoute;
use Cp\Layout as CpLayout;
use Cp\Redis as CpRedis;
use Zend\Db\Adapter\Adapter as ZendDbAdapter;


use Orm\Mapper\Core\ShopModel as shopMapper;

/**
 * 引导调度类, 初始化
 */
class Bootstrap extends Bootstrap_Abstract
{

    /**
     * Yaf的配置缓存
     *
     * @var \Yaf\Config\Ini
     */
    protected $config = null;

    /**
     * 数据库的配置文件
     *
     * @var \Yaf\Config\Ini
     */
    protected $databaseConfig = null;

    /**
     * 当前登录的卖家ID
     *
     * @var int
     */
    protected static $userId = 0;

    /**
     * 当前登录的卖家昵称
     *
     * @var string
     */
    protected static $userNick = '';


    /**
     * 当前登录的卖家模型
     *
     * @var \Orm\UserModel|null
     */
    protected static $userModel = null;

    /**
     * 把配置存到注册表
     */
    public function _initConfig()
    {
        $this->config = Application::app()->getConfig();
        Registry::set('config', $this->config);

        /*
         * 数据库的配置文件
         *
         * 之所以独立出来:
         * 1. 要连接很多个数据库.
         * 2. 并非所有的请求都需要连接数据库.
         */
        $dbIniPath = APPLICATION_PATH . '/conf/database.ini';

        $this->databaseConfig = new Ini($dbIniPath, Application::app()->environ());
        Registry::set('databaseConfig', $this->databaseConfig);
    }

    /**
     * 重新设置一些PHP配置
     */
    public function _initPhpIni()
    {
        $phpSettings = $this->config->get('phpsettings');
        if ($phpSettings instanceof Ini) {
            foreach ($phpSettings->toArray() as $key => $value) {
                $this->phpIniSet($key, $value);
            }
        }
    }

    /**
     * 设置ini
     *
     * @param string $key 配置项.
     * @param mixed $val 配置值.
     * @param string $prefix 用于和 "$key" 拼接 "." 连接符
     */
    protected function phpIniSet($key, $val = null, $prefix = '')
    {
        $prefix .= $prefix ? ('.' . $key) : $key;

        if (is_array($val)) {
            foreach ($val as $k => $v) {
                $this->phpIniSet($k, $v, $prefix);
            }
        }
        else {
            ini_set($prefix, $val);
        }
    }

    /**
     * 初始化shop信息
     */
    public function _initShop()
    {
        if (!\Yaf\Application::app()->getDispatcher()->getRequest()->isCli()) {

        }
    }

    /**
     * 处理会话
     * Session 直接交由Yaf自带的类去处理.
     */
    public function _initSession()
    {
        Session::getInstance();
    }

    /**
     * 注册本地类
     */
    public function _initRegisterLocalNamespace()
    {
        Loader::getInstance()->registerLocalNamespace(array('Zend', 'St', 'Top'));
    }

    /**
     * 通过派遣器得到默认的路由器
     * 主要有以下几种路由协议
     *
     * Yaf\Route_Simple
     * Yaf\Route_Supervar
     * Yaf\Route_Static
     * Yaf\Route_Map
     * Yaf\Route_Rewrite
     * Yaf\Route_Regex
     *
     * @param \Yaf\Dispatcher $dispatcher
     */
    public function _initRoute(Dispatcher $dispatcher)
    {
        /**
         * 通过派遣器得到默认的路由器
         */
        /* @var $router \Yaf\Router */
        $router = $dispatcher->getRouter();

        if ($this->config->routes) {
            $router->addConfig($this->config->routes);
        }

//        // 添加一个以 Module\Controller\Acation 方式优先的路由.
//        $mcaRoute = new StRoute();
//        $router->addRoute('Kumca', $mcaRoute);
    }

    /**
     * Redis数据库
     *
     * @throws Exception 'Redis is need redis Extension!
     */
    public function _initRedis()
    {
        $conf = $this->config->get('resources.redis');

        if (!$conf) {
            throw new Exception('Not redis configure!', 503);
        }

        $redis = new CpRedis();

        /*
         * 连接Redis
         *
         * 当没有定义 port 时, 可以支持 sock.
         * 但是, 需要注意: 如果host是IP或者主机名时, port 的默认值是 6379
         */
        if ($conf->get('port')) {
            $status = $redis->pconnect($conf->get('host'), $conf->get('port'));
        }
        else {
            $status = $redis->pconnect($conf->get('host'));
        }

        if (!$status) {
            throw new \Exception('Unable to connect to the redis:' . $conf->get('host'));
        }

        // 是否有密码
        if ($conf->get('auth')) {
            $redis->auth($conf->get('auth'));
        }

        // 是否要切换Db
        if ($conf->get('db')) {
            $redis->select($conf->get('db'));
        }

        // Key前缀
        if ($conf->get('options.prefix')) {
            $redis->setOption(\Redis::OPT_PREFIX, $conf->get('options.prefix'));
        }

        Registry::set('redis', $redis);
    }

    /**
     * 设置Layout
     *
     * @param \Yaf\Dispatcher $dispatcher
     */
    public function _initLayout(Dispatcher $dispatcher)
    {
        $layout = new CpLayout($this->config->get('application.layout.directory'));
        $dispatcher->setView($layout);
        Registry::set('layout', $layout);
    }

    /**
     * 注册插件
     *
     * @param Yaf\Dispatcher $dispatcher
     */
    public function _initPlugins(Yaf\Dispatcher $dispatcher)
    {
        $config = $this->config->get('application.bootstrap.plugins');

        if (empty($config)) {
            return null;
        }

        $plugins = explode(',', $config);

        foreach ($plugins as $value) {
            $item = trim($value);
            if (!empty($item)) {
                $dispatcher->registerPlugin(new $item());
            }
        }
    }

    /**
     * 当前是否处于开发环境
     *
     * @return boolean
     */
    public static function isDevelop()
    {
        return ('develop' == Application::app()->environ()) ? true : false;
    }

    /**
     * 当前登录的卖家, 是否属于我们自己的管理员账号
     *
     * @return boolean
     */
    public static function isAdmin()
    {
        $shopIds = [
            2881064 => false,

        ];

        return (isset($shopIds[self::getShopId()]) and $shopIds[self::getShopId()]) ? true : false;
    }

    /**
     * 当前登录的卖家, 是否属性属于测试账号
     *
     * @return boolean
     */
    public static function isTestShop()
    {
        $shopIds = [
            2881064 => false,
        ];

        return (isset($shopIds[self::getShopId()]) and $shopIds[self::getShopId()]) ? true : false;
    }

    /**
     * 是否属于需要特殊记录的账号
     */
    public static function isSpecialNick($nick)
    {
        $nicks = [
            'menico' => true,
        ];

        return (isset($nicks[$nick]) && $nicks[$nick]) ? true : false;
    }

    /**
     * 取得当前配置
     *
     * @return \Yaf\Config\Ini
     */
    public static function getConfig()
    {
        return \Yaf\Application::app()->getConfig();
    }

    /**
     * 获取Redis的连接
     *
     * @return \St\Redis|null
     */
    public static function getRedis()
    {
        return Registry::get('redis');
    }

    /**
     * 返回Zend的数据层适配器
     *
     * 因为数据库有很多实例,
     * 所以, 需要事先指定是哪个实例的适配器
     *
     * @param string $project 项目名称, 例如:core, bug
     * @return \Zend\Db\Adapter\Adapter
     */
    public static function getDbAdapter($project)
    {
        static $adapterArr = array();

        if (isset($adapterArr[$project])) {
            return $adapterArr[$project];
        }

        /* @var $conf \Yaf\Config\Ini */
        $conf = Registry::get('databaseConfig')->get($project);

        if (empty($conf)) {
            throw new \Exception("Not database configure ({$project})", 503);
        }

        $adapter = new ZendDbAdapter($conf->toArray());

        $adapterArr[$project] = $adapter;

        return $adapter;
    }

    /**
     * 获取默认域名
     */
    public static function getBaseUrl($type = 'baseUrl')
    {
        $application = self::getConfig()->get('application');

        return $application[$type];
    }

    /**
     * 构造访问链接
     * @param $routeUrl string
     */
    public static function getUrl($routeUrl)
    {
        $baseUrl = rtrim(self::getBaseUrl(), '/') . '/';

        $routeArr = explode('/', $routeUrl);

        if (!empty($routeArr)) {
            $routeArr = array_values(array_filter($routeArr));
        }

        $model      = isset($routeArr[0]) ? $routeArr[0] : 'index';
        $controller = isset($routeArr[1]) ? $routeArr[1] : 'index';
        $action     = isset($routeArr[2]) ? $routeArr[2] : 'index';

        $routeUrl = $model . '/' . $controller . '/' . $action;

        return $baseUrl . $routeUrl;
    }

    /**
     * 构造访问的CDN
     * 线上环境不需要考虑配置
     * 本地环境需要按模块修改读取的静态路径
     */
    public static function getCdn($dir = '')
    {
        $view = self::getConfig()->get('view');
        $cdn  = $view['baseUrl']['cdn'];

        return self::isDevelop() ? $cdn . $dir . '/' : $cdn;
    }

    /**
     * 构造文件地址路径
     */
    public static function getDataDir($dir = '')
    {
        $data = self::getConfig()->get('data');
        $url = $data['directory'];

        return empty($dir) ? $url : $url.'/'.$dir;

    }






    /**
     * 获取当前登录卖家的userNick
     */
    public static function getShopNick()
    {
        return self::$userNick;
    }


    /**
     * 记录报错
     */
    public static function exportLog($e,$server=null)
    {
        var_dump($e);exit;

//        \Track\ErrorModel::send($e,$server);
    }

}

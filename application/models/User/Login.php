<?php
/**
 * Created by PhpStorm.
 * User: abu
 * Date: 16/6/1
 * Time: 下午7:44
 */

namespace User;

use Cp\Tool;
use Cp\Is;
use Cp\Str;
use Orm\Mapper\UsersModel as MapUsers;
use Orm\UsersModel as ModUsers;

class LoginModel
{
    /**
     * 单例
     *
     * @var LoginModel
     */
    protected static $instance = null;

    /**
     * 单例接口
     *
     * @return LoginModel
     */
    public static function getInstance()
    {
        if (null === static::$instance) {
            static::$instance = new static();
        }

        return static::$instance;
    }

    /**
     * @param $username
     * @param $password
     */
    public function isAdminUser($username,$password)
    {
        if(!Is::email($username)){
            return false;
        }
        $username = Str::htmlspecialchars($username);
        $password = Str::htmlspecialchars($password);

        $mapUsers = MapUsers::getInstance();
        $modUsers = $mapUsers->findByEmail($username);
        if(!$modUsers instanceof ModUsers){
            return false;
        }
        $defPassword = $modUsers->getPassword();
        $inPassword = password_hash($password.'sarumi');
        if($inPassword != $defPassword){
            return false;
        }

        return true;



    }

}
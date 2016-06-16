<?php
/**
 * Created by PhpStorm.
 * User: abu
 * Date: 16/5/31
 * Time: 上午10:50
 */

use Base\AdminController;

use \User\LoginModel;

/**
 * 登录管理
 */
class LoginController extends AdminController
{
    /**
     * 布局模板的名称
     * @var string
     */
    protected $layout = 'login';

    public function indexAction()
    {

        /**
         * 生成登录token 放在session里面
         */


    }

    /**
     * 登录验证
     *
     * 从session里面取出token
     *
     */
    public function signinAction()
    {
        $this->disableView();
        $request = $this->getRequest();
        $username = trim($request->get('username',''));
        $password = trim($request->get('password',''));


        password_hash('sarumi',PASSWORD_BCRYPT);
        password_verify('sarumi',PASSWORD_BCRYPT);

        $islogin = LoginModel::getInstance()->isAdminUser($username,$password);

        if($islogin){
            $this->redirect('/admin/index/index');
        }else{
            $this->redirect('/admin/login/index');
        }
    }



}
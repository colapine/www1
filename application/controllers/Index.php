<?php

use Base\ApplicationController;

use Sess\LoginModel;
/**
 * 首页
 */
class IndexController extends ApplicationController
{

    /**
     * 布局模板的名称
     * @var string
     */
    protected $layout = null;

    /**
     * 首页
     *
     * 主要起授权验证作用
     */
    public function indexAction()
    {
        $this->disableView();


        /**
         * 没有 登录
         * 跳转到 TOP 授权
         */
//        if (!$this->isLogined()) {
//
//            $this->gotoTopAuthUrl();
//            return true;
//        }

        /* 其他情况, 跳转到功能首页 */
        $this->redirect(\Bootstrap::getUrl('admin/index/index'));

        return true;
    }


    /**
     * 判断用户是否已登录
     *
     * 判断逻辑: session 中是否有 shop
     *          created 是否超过24小时
     *
     * @return boolean
     */
    protected function isLogined()
    {
        return LoginModel::getInstance()->isLogined();
    }

    /**
     * 跳转到TOP授权页面, 并结束此次的请求
     */
    protected function gotoTopAuthUrl()
    {
        $url = \Bootstrap::getTopurl();

        header('St-message: Not logged in');
        header('Location: ' . $url);
        die();
    }

}

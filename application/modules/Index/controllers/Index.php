<?php

use Base\AdminController;

/**
 * 首页
 */
class IndexController extends AdminController
{

    public function indexAction()
    {

        echo 'aaaa';


        $this->assign('test', 11);
    }

    /**
     * 输出服务器 PHP info
     */
    public function phpinfoAction()
    {
        $this->disableView();
        phpinfo();
    }

}

<?php

use Base\ApplicationController;

/**
 * 首页
 */
class IndexController extends ApplicationController
{

    public function indexAction()
    {

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

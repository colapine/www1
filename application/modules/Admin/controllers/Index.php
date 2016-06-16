<?php

use Base\AdminController;

/**
 * 管理员后台
 */
class IndexController extends AdminController
{

    public function indexAction()
    {
        $this->assign('test', 11);
    }


    /**
     * 游戏界面
     */
    public function gameAction()
    {

    }

}

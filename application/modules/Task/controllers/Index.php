<?php

use Base\ApplicationController;

/**
 * 首页
 */
class IndexController extends ApplicationController
{

    /**
     * @example php -f task.php request_uri=/task/index/index
     */

    public function indexAction()
    {
        $this->disableView();
        $la = array(
            '1'=>'中文',
            '2'=>'日语'
        );
        $cy = array(
            '1'=>'中国',
            '2'=>'日本',
            '3'=>'韩国'
        );
        $gr= array(
            '1'=>'全0',
            '2'=>'R15',
            '3'=>'R18',
            '4'=>'R25'
        );
        $booktype = array(
            '1'=>'小说',
            '2'=>'漫画'
        );

        echo json_encode($la, JSON_UNESCAPED_UNICODE);
        echo json_encode($cy, JSON_UNESCAPED_UNICODE);
        echo json_encode($gr, JSON_UNESCAPED_UNICODE);
        echo json_encode($booktype, JSON_UNESCAPED_UNICODE);

    }



}

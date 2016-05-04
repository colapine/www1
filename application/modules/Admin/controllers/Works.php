<?php

use Base\AdminController;

use Orm\Mapper\WorksModel as MapWorks;
use Orm\WorksModel as ModWorks;

/**
 * 作品管理
 */
class WorksController extends AdminController
{

    public function indexAction()
    {

        echo 'aaaa';


        $this->assign('test', 11);
    }

    public function addAction()
    {
        $this->disableView();

        $mapWorks = MapWorks::getInstance();
        $modWorks = new ModWorks();
        $modWorks->setType(1)->setName('K')->setName('pics')->setDetails('xxx')
            ->setLanguage('2')->setPics('xx');

        $mapWorks->insert($modWorks);






    }



}

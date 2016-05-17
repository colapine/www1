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

        $request = $this->getRequest();

        $page_num  = abs(intval($request->get('page_num', 1)));
        $page_size = abs(intval($request->get('page_size', 35)));

        $mapWorks = MapWorks::getInstance();
        $total    = $mapWorks->count(null);
        $workses    = $mapWorks->fetchAll(null, 'id desc', $page_size, ($page_num - 1) * $page_size);

        $config = \Works\ConfigModel::getInstance()->getSetting();

        $this->assign('total',$total);
        $this->assign('workses',$workses);
        $this->assign('config',$config);
    }


    public function replaceAction()
    {

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

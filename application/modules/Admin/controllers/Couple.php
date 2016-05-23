<?php

use Base\AdminController;

use Orm\Mapper\CoupleModel as MapCouple;
use Orm\CoupleModel as ModCouple;

/**
 * CP管理
 */
class CoupleController extends AdminController
{

    public function indexAction()
    {

        $request = $this->getRequest();

        $page_num  = abs(intval($request->get('page_num', 1)));
        $page_size = abs(intval($request->get('page_size', 35)));

        $mapCouple = MapCouple::getInstance();
        $total    = $mapCouple->count(null);
        $couples  = $mapCouple->fetchAll(null, 'id desc', $page_size, ($page_num - 1) * $page_size);

        $config = \Couple\ConfigModel::getInstance()->getSetting();

        $this->assign('total', $total);
        $this->assign('couple', $couples);
        $this->assign('config', $config);
    }


    public function replaceAction()
    {
        $id       = intval($this->getRequest()->get('id'));
        $couple = '';
        if($id){
            $modCouple = MapCouple::getInstance()->find($id);
            if($modCouple instanceof ModCouple){
                $couple = $modCouple->toArray();
            }
        }

        $config = \Couple\ConfigModel::getInstance()->getSetting();

        $this->assign('config', $config);
        $this->assign('couple',$couple);
    }


    public function addAction()
    {
        $this->disableView();

        $request  = $this->getRequest();
        $name    = trim($request->get('name'));
        $works_id    = trim($request->get('works_id'));
        $detail   = trim($request->get('detail'));


        $mapCouple = MapCouple::getInstance();
        $modCouple = new ModCouple();

        $modCouple->setName($name)
            ->setWorksId($works_id)
            ->setDetails($detail);


        $mapCouple->insert($modCouple);
        $this->redirect($this->getUrl('admin/couple/index'));
    }

    public function updateAction()
    {
        $this->disableView();

        $request  = $this->getRequest();
        $id       = trim($request->get('id'));
        $name    = trim($request->get('name'));
        $works_id    = trim($request->get('works_id'));
        $detail   = trim($request->get('detail'));


        $mapCouple = MapCouple::getInstance();
        $modCouple = $mapCouple->find($id);
        if($modCouple instanceof ModCouple){

            $modCouple->setName($name)
                ->setWorksId($works_id)
                ->setDetails($detail);

            $mapCouple->update($modCouple);
        }

        $this->redirect($this->getUrl('admin/couple/index'));
    }

    public function deleteAction()
    {
        $id       = intval($this->getRequest()->get('id'));
        if($id){
            $mapCouple = MapCouple::getInstance();
            $modCouple = $mapCouple->find($id);
            if($modCouple instanceof ModCouple){
                $mapCouple->delete($modCouple);
            }
        }
        $this->redirect($this->getUrl('admin/couple/index'));
    }


}

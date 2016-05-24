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
        $workses  = $mapWorks->fetchAll(null, 'id desc', $page_size, ($page_num - 1) * $page_size);

        $config = \Works\ConfigModel::getInstance()->getSetting();

        $this->assign('total', $total);
        $this->assign('workses', $workses);
        $this->assign('config', $config);
    }


    public function replaceAction()
    {
        $id       = intval($this->getRequest()->get('id'));
        $works = '';
        if($id){
            $modWorks = MapWorks::getInstance()->find($id);
            if($modWorks instanceof ModWorks){
                $works = $modWorks->toArray();
            }
        }

        $config = \Works\ConfigModel::getInstance()->getSetting();

        $this->assign('config', $config);
        $this->assign('works',$works);
    }


    public function addAction()
    {
        $this->disableView();

        $request  = $this->getRequest();
        $pics    = trim($request->get('pics'));
        $title    = trim($request->get('title'));
        $title_zh = trim($request->get('title_zh'));
        $subtitle = trim($request->get('subtitle'));
        $language = intval($request->get('language', 1));
        $detail   = trim($request->get('detail'));


        $mapWorks = MapWorks::getInstance();
        $modWorks = new ModWorks();

        $modWorks->setPics($pics)
            ->setTitle($title)
            ->setTitleZh($title_zh)
            ->setSubtitle($subtitle)
            ->setLanguage($language)
            ->setDetails($detail);

        $mapWorks->insert($modWorks);
        $this->redirect($this->getUrl('admin/works/index'));
    }

    public function updateAction()
    {
        $this->disableView();

        $request  = $this->getRequest();
        $id       = trim($request->get('id'));
        $pics    = trim($request->get('pics'));
        $title    = trim($request->get('title'));
        $title_zh = trim($request->get('title_zh'));
        $subtitle = trim($request->get('subtitle'));
        $language = intval($request->get('language', 1));
        $detail   = trim($request->get('detail'));

        $mapWorks = MapWorks::getInstance();
        $modWorks = $mapWorks->find($id);
        if($modWorks instanceof ModWorks){

            $modWorks->setPics($pics)
                ->setTitle($title)
                ->setTitleZh($title_zh)
                ->setSubtitle($subtitle)
                ->setLanguage($language)
                ->setDetails($detail);

            $mapWorks->update($modWorks);
        }

        $this->redirect($this->getUrl('admin/works/index'));
    }

    public function deleteAction()
    {
        $id       = intval($this->getRequest()->get('id'));
        if($id){
            $mapWorks = MapWorks::getInstance();
            $modWorks = $mapWorks->find($id);
            if($modWorks instanceof ModWorks){
                $mapWorks->delete($modWorks);
            }
        }
        $this->redirect($this->getUrl('admin/works/index'));
    }


}

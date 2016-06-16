<?php

use Base\AdminController;
use Cp\Tool;

use Orm\Mapper\ConfigModel as MapConfig;
use Orm\ConfigModel as ModConfig;

/**
 * 配置管理
 */
class ConfigController extends AdminController
{

    public function indexAction()
    {
        $mapConfig = MapConfig::getInstance();
        $total     = $mapConfig->count(null);
        $configs   = $mapConfig->fetchAll(null);

        $this->assign('total', $total);
        $this->assign('configs', $configs);
    }


    public function addAction()
    {
        $this->disableView();

        $request = $this->getRequest();
        $key     = $request->get('typename');
        $id      = intval($request->get('typeid'));
        $desc    = $request->get('json');

        eval("\$desc=$desc;");
        $desc = json_encode($desc,JSON_UNESCAPED_UNICODE);

        $mapConfig = MapConfig::getInstance();
        $modConfig = new ModConfig();
        $modConfig->setTypeid($id)
            ->setTypename($key)
            ->setJson($desc);
        $mapConfig->insert($modConfig);

        $this->redirect($this->getUrl('admin/config/index'));
    }

    public function updateAction()
    {
        $this->disableView();

        $request   = $this->getRequest();
        $typenames = $request->get('typename', []);
        $typeids   = $request->get('typeid', []);
        $json      = $request->get('json');

        $mapConfig = MapConfig::getInstance();

        foreach ($typeids as $k => $id) {
            $modConfig = $mapConfig->find($k);

            $key  = $typenames[$k];
            $desc = '';
            if(!empty($json[$k])){
                eval("\$desc=$json[$k];");
                $desc = json_encode($desc,JSON_UNESCAPED_UNICODE);
            }


            $modConfig->setTypeid($id)
                ->setTypename($key)
                ->setJson($desc);
            $mapConfig->update($modConfig);
        }

        $this->redirect($this->getUrl('admin/config/index'));
    }

    public function deleteAction()
    {
        $id = intval($this->getRequest()->get('id'));
        if ($id) {
            $mapConfig = MapConfig::getInstance();
            $modConfig = $mapConfig->find($id);
            if ($modConfig instanceof ModConfig) {
                $mapConfig->delete($modConfig);
            }
        }
        $this->redirect($this->getUrl('admin/config/index'));
    }


}

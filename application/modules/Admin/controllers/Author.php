<?php

use Base\AdminController;

use Orm\Mapper\AuthorModel as MapAuthor;
use Orm\AuthorModel as ModAuthor;

/**
 * 作者管理
 */
class AuthorController extends AdminController
{

    public function indexAction()
    {
        $request = $this->getRequest();

        $page_num  = abs(intval($request->get('page_num', 1)));
        $page_size = abs(intval($request->get('page_size', 35)));

        $mapAuthor = MapAuthor::getInstance();
        $total     = $mapAuthor->count(null);
        $authors   = $mapAuthor->fetchAll(null, 'id desc', $page_size, ($page_num - 1) * $page_size);

        $config = \Author\ConfigModel::getInstance()->getSetting();

        $this->assign('config', $config);
        $this->assign('total', $total);
        $this->assign('authors', $authors);
    }

    public function replaceAction()
    {
        $config = \Author\ConfigModel::getInstance()->getSetting();

        $id     = abs(intval($this->getRequest()->get('id', 0)));
        $author = '';
        if ($id) {
            $modAuthor = MapAuthor::getInstance()->find($id);
            if ($modAuthor) {
                $author = $modAuthor->toArray();
            }
        }

        $this->assign('author', $author);
        $this->assign('config', $config);

    }

    /**
     * 接口  新增本子信息
     */
    public function addAction()
    {
        $this->disableView();

        $request = $this->getRequest();
        $name    = trim($request->get('name'));
        $alias   = trim($request->get('alias'));
        $country = intval($request->get('country'));
        $sex     = intval($request->get('sex'));


        $mapAuthor = MapAuthor::getInstance();
        $modAuthor = new ModAuthor();
        $modAuthor
            ->setName($name)
            ->setAlias($alias)
            ->setCountry($country)
            ->setSex($sex);

        $mapAuthor->insert($modAuthor);

        $this->redirect($this->getUrl('admin/author/index'));
    }

    /**
     * 接口
     * 更新信息
     */
    public function updateAction()
    {
        $this->disableView();

        $request = $this->getRequest();
        $id      = intval($request->get('id', 0));
        $name    = trim($request->get('name'));
        $alias   = trim($request->get('alias'));
        $country = intval($request->get('country'));
        $sex     = intval($request->get('sex'));

        $mapAuthor = MapAuthor::getInstance();
        $modAuthor = $mapAuthor->find($id);
        if (empty($modAuthor)) {
            $this->redirect($this->getUrl('admin/author/index'));
        }

        $modAuthor
            ->setName($name)
            ->setAlias($alias)
            ->setCountry($country)
            ->setSex($sex);
        $mapAuthor->update($modAuthor);

        $this->redirect($this->getUrl('admin/author/index'));
    }

    /**
     * 接口
     * 删除
     */
    public function deleteAction()
    {
        $this->disableView();

        $request   = $this->getRequest();
        $id        = intval($request->get('id', 0));
        $mapAuthor = MapAuthor::getInstance();
        $modAuthor = $mapAuthor->find($id);
        if (!empty($modAuthor)) {
            $mapAuthor->delete($modAuthor);
        }

        $this->redirect($this->getUrl('admin/author/index'));

    }


}

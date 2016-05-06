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

        $page_num = abs(intval($request->get('page_num',1)));
        $page_size = abs(intval($request->get('page_size',35)));

        $mapAuthor = MapAuthor::getInstance();
        $total = $mapAuthor->count(null);
        $books = $mapAuthor->fetchAll(null ,'id desc',$page_size,($page_num-1)*$page_size);


        $this->assign('total', $total);
        $this->assign('books',$books);
    }

    public function addAction()
    {

    }

    /**
     * 接口  新增本子信息
     */
    public function ifaddAction()
    {
        $this->disableView();

        $request = $this->getRequest();
        $title = $request->get('title');
        $title_ch = $request->get('title_ch');
        $couple = intval($request->get('couple'));
        $work  = intval($request->get('work'));
        $author = intval($request->get('author'));


        $mapAuthor = MapAuthor::getInstance();
        $modAuthor = new ModAuthor();


        $mapAuthor->insert($modAuthor);

        $this->redirect($this->getUrl('admin/books/index'));
    }



}

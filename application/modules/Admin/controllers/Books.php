<?php

use Base\AdminController;
use \Zend\Db\Sql\Where;

use Orm\Mapper\BooksModel as MapBooks;
use Orm\BooksModel as ModBooks;

/**
 * 本子管理
 */
class BooksController extends AdminController
{

    public function indexAction()
    {
        $request = $this->getRequest();

        $page_num = abs(intval($request->get('page_num',1)));
        $page_size = abs(intval($request->get('page_size',35)));

        $mapBooks = MapBooks::getInstance();
        $total = $mapBooks->count(null);
        $books = $mapBooks->fetchAll(null ,'id desc',$page_size,($page_num-1)*$page_size);


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


        $mapBooks = MapBooks::getInstance();
        $modBooks = new ModBooks();

        $modBooks->setLanguage(1)->setTitle($title)->setTitleCh($title_ch)
            ->setDetails('')->setAuthorId($author)->setWorksId($work)
            ->setCoupleId($couple)->setCover('');

        $mapBooks->insert($modBooks);

        $this->redirect($this->getUrl('admin/books/index'));
    }



}

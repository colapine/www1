<?php

use Base\AdminController;

use Orm\Mapper\BooksModel as MapBooks;
use Orm\BooksModel as ModBooks;

/**
 * 本子管理
 */
class BooksController extends AdminController
{

    public function indexAction()
    {

        echo 'aaaa';


        $this->assign('test', 11);
    }

    public function addAction()
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



    }



}

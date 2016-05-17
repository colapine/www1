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

        $page_num  = abs(intval($request->get('page_num', 1)));
        $page_size = abs(intval($request->get('page_size', 35)));

        $mapBooks = MapBooks::getInstance();
        $total    = $mapBooks->count(null);
        $books    = $mapBooks->fetchAll(null, 'id desc', $page_size, ($page_num - 1) * $page_size);

        $config = \Books\ConfigModel::getInstance()->getSetting();

        $this->assign('total', $total);
        $this->assign('books', $books);
        $this->assign('config', $config);
    }

    public function replaceAction()
    {
        $config = \Books\ConfigModel::getInstance()->getSetting();

        $id   = abs(intval($this->getRequest()->get('id', 0)));
        $book = '';
        if ($id) {
            $modBook = MapBooks::getInstance()->find($id);
            if ($modBook) {
                $book = $modBook->toArray();
            }
        }

        $this->assign('book', $book);
        $this->assign('config', $config);

    }

    /**
     * 接口  新增本子信息
     */
    public function addAction()
    {
        $this->disableView();

        $request    = $this->getRequest();
        $title      = $request->get('title');
        $title_zh   = $request->get('title_zh');
        $couple     = intval($request->get('couple'));
        $work       = intval($request->get('work'));
        $author     = intval($request->get('author'));
        $graduation = intval($request->get('graduation'));
        $language   = intval($request->get('language'));


        $mapBooks = MapBooks::getInstance();
        $modBook  = new ModBooks();

        $modBook->setLanguage(1)
            ->setTitle($title)
            ->setTitleZh($title_zh)
            ->setDetails('')
            ->setAuthorId($author)
            ->setWorksId($work)
            ->setCoupleId($couple)
            ->setCover('')
            ->setGraduation($graduation)
            ->setLanguage($language);

        $mapBooks->insert($modBook);

        $this->redirect($this->getUrl('admin/books/index'));
    }

    /**
     * 接口
     * 更新信息
     */
    public function updateAction()
    {
        $this->disableView();

        $request    = $this->getRequest();
        $id         = intval($request->get('id', 0));
        $title      = trim($request->get('title'));
        $title_zh   = trim($request->get('title_zh'));
        $couple     = intval($request->get('couple'));
        $work       = intval($request->get('work'));
        $author     = intval($request->get('author'));
        $graduation = intval($request->get('graduation'));
        $language   = intval($request->get('language'));

        $mapBooks = MapBooks::getInstance();
        $modBook  = $mapBooks->find($id);
        if (empty($modBook)) {
            $this->redirect($this->getUrl('admin/books/index'));
        }

        $modBook->setLanguage(1)
            ->setTitle($title)
            ->setTitleZh($title_zh)
            ->setDetails('')
            ->setAuthorId($author)
            ->setWorksId($work)
            ->setCoupleId($couple)
            ->setCover('')
            ->setGraduation($graduation)
            ->setLanguage($language);
        $mapBooks->update($modBook);

        $this->redirect($this->getUrl('admin/books/index'));
    }

    /**
     * 接口
     * 删除
     */
    public function deleteAction()
    {
        $this->disableView();

        $request    = $this->getRequest();
        $id         = intval($request->get('id', 0));
        $mapBooks = MapBooks::getInstance();
        $modBook  = $mapBooks->find($id);
        if (!empty($modBook)) {
            $mapBooks->delete($modBook);
        }

        $this->redirect($this->getUrl('admin/books/index'));

    }

}

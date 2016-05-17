<?php

namespace Orm;

use Orm\Base\Model\AbstractModel;

/**
 * 数据模型
 * 
 * Table: books
 */
class BooksModel extends AbstractModel
{

    /**
     * 
     *
     * @var Int
     */
    protected $id = null;

    /**
     * 
     *
     * @var String
     */
    protected $title = null;

    /**
     * 
     *
     * @var String
     */
    protected $titleZh = null;

    /**
     * 
     *
     * @var Int
     */
    protected $coupleId = 0;

    /**
     * 作品ID
     *
     * @var Int
     */
    protected $worksId = 0;

    /**
     * 详情
     *
     * @var String
     */
    protected $details = null;

    /**
     * 作者ID
     *
     * @var Int
     */
    protected $authorId = 0;

    /**
     * 封面
     *
     * @var String
     */
    protected $cover = null;

    /**
     * 分级
     *
     * @var Int
     */
    protected $graduation = 0;

    /**
     * 
     *
     * @var Int
     */
    protected $language = 0;

    /**
     * 
     *
     * @var Int
     */
    protected $createtime = 0;

    /**
     * 
     *
     * @var Int
     */
    protected $updatetime = 0;

    /**
     * 获取 
     *
     * @return Int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * 设置 
     *
     * database: int(11)
     * @param Int $id 
     * @return \Orm\BooksModel
     */
    public function setId($id)
    {
        $this->id = intval($id);
        return $this;
    }

    /**
     * 获取 
     *
     * @return String
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * 设置 
     *
     * database: varchar(100)
     * @param String $title 
     * @return \Orm\BooksModel
     */
    public function setTitle($title)
    {
        $this->title = trim($title);
        return $this;
    }

    /**
     * 获取 
     *
     * @return String
     */
    public function getTitleZh()
    {
        return $this->titleZh;
    }

    /**
     * 设置 
     *
     * database: varchar(100)
     * @param String $titleZh 
     * @return \Orm\BooksModel
     */
    public function setTitleZh($titleZh)
    {
        $this->titleZh = trim($titleZh);
        return $this;
    }

    /**
     * 获取 
     *
     * @return Int
     */
    public function getCoupleId()
    {
        return $this->coupleId;
    }

    /**
     * 设置 
     *
     * database: int(11) unsigned
     * @param Int $coupleId 
     * @return \Orm\BooksModel
     */
    public function setCoupleId($coupleId)
    {
        $this->coupleId = abs(intval($coupleId));
        return $this;
    }

    /**
     * 获取 作品ID
     *
     * @return Int
     */
    public function getWorksId()
    {
        return $this->worksId;
    }

    /**
     * 设置 作品ID
     *
     * database: int(11) unsigned
     * @param Int $worksId 作品ID
     * @return \Orm\BooksModel
     */
    public function setWorksId($worksId)
    {
        $this->worksId = abs(intval($worksId));
        return $this;
    }

    /**
     * 获取 详情
     *
     * @return String
     */
    public function getDetails()
    {
        return $this->details;
    }

    /**
     * 设置 详情
     *
     * database: varchar(500)
     * @param String $details 详情
     * @return \Orm\BooksModel
     */
    public function setDetails($details)
    {
        $this->details = trim($details);
        return $this;
    }

    /**
     * 获取 作者ID
     *
     * @return Int
     */
    public function getAuthorId()
    {
        return $this->authorId;
    }

    /**
     * 设置 作者ID
     *
     * database: int(11)
     * @param Int $authorId 作者ID
     * @return \Orm\BooksModel
     */
    public function setAuthorId($authorId)
    {
        $this->authorId = intval($authorId);
        return $this;
    }

    /**
     * 获取 封面
     *
     * @return String
     */
    public function getCover()
    {
        return $this->cover;
    }

    /**
     * 设置 封面
     *
     * database: varchar(200)
     * @param String $cover 封面
     * @return \Orm\BooksModel
     */
    public function setCover($cover)
    {
        $this->cover = trim($cover);
        return $this;
    }

    /**
     * 获取 分级
     *
     * @return Int
     */
    public function getGraduation()
    {
        return $this->graduation;
    }

    /**
     * 设置 分级
     *
     * database: tinyint(2) unsigned
     * @param Int $graduation 分级
     * @return \Orm\BooksModel
     */
    public function setGraduation($graduation)
    {
        $this->graduation = abs(intval($graduation));
        return $this;
    }

    /**
     * 获取 
     *
     * @return Int
     */
    public function getLanguage()
    {
        return $this->language;
    }

    /**
     * 设置 
     *
     * database: tinyint(2) unsigned
     * @param Int $language 
     * @return \Orm\BooksModel
     */
    public function setLanguage($language)
    {
        $this->language = abs(intval($language));
        return $this;
    }

    /**
     * 获取 
     *
     * @return Int
     */
    public function getCreatetime()
    {
        return $this->createtime;
    }

    /**
     * 设置 
     *
     * database: int(10) unsigned
     * @param Int $createtime 
     * @return \Orm\BooksModel
     */
    public function setCreatetime($createtime)
    {
        $this->createtime = abs(intval($createtime));
        return $this;
    }

    /**
     * 获取 
     *
     * @return Int
     */
    public function getUpdatetime()
    {
        return $this->updatetime;
    }

    /**
     * 设置 
     *
     * database: int(10) unsigned
     * @param Int $updatetime 
     * @return \Orm\BooksModel
     */
    public function setUpdatetime($updatetime)
    {
        $this->updatetime = abs(intval($updatetime));
        return $this;
    }

    /**
     * @return array
     */
    public function toArray()
    {
        return array(
            'id'         => $this->id,
            'title'      => $this->title,
            'title_zh'   => $this->titleZh,
            'couple_id'  => $this->coupleId,
            'works_id'   => $this->worksId,
            'details'    => $this->details,
            'author_id'  => $this->authorId,
            'cover'      => $this->cover,
            'graduation' => $this->graduation,
            'language'   => $this->language,
            'createtime' => $this->createtime,
            'updatetime' => $this->updatetime,
        );
    }

}

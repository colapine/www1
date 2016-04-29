<?php

namespace Cp\Response\Ajax;

/**
 * 资源, 列表类型
 *
 * 为前端 前后端异步传值规范 所设计的统一输出结构
 *
 * @link
 */
class ResultList
{

    /**
     * 数据总数
     * @var int
     */
    protected $totalRecords = 0;

    /**
     * 当前页数
     * @var int
     */
    protected $pageNum = 1;

    /**
     * 每页几条数据
     * @var int
     */
    protected $pageSize = 0;

    /**
     * 列表内容
     * @var array
     */
    protected $list = array();

    /**
     * 其它附加数据
     *
     * @var array
     */
    protected $otherData = array();

    /**
     *
     * @param array|mixed $list
     * @param int $totalRecords
     * @param int $pageNum
     * @param int $pageSize
     */
    public function __construct($list = array(), $totalRecords = 0, $pageNum = 1, $pageSize = 0)
    {
        $this->setList($list);
        $this->setTotalRecords($totalRecords);
        $this->setPageNum($pageNum);
        $this->setPageSize($pageSize);
    }

    public function getTotalRecords()
    {
        return $this->totalRecords;
    }

    public function getPageNum()
    {
        return $this->pageNum;
    }

    public function getPageSize()
    {
        return $this->pageSize;
    }

    public function getList()
    {
        return $this->list;
    }

    /**
     * 总数据量
     *
     * @param int $totalRecords
     * @return \Cp\Response\Ajax\ResultList
     */
    public function setTotalRecords($totalRecords)
    {
        $this->totalRecords = abs(intval($totalRecords));
        return $this;
    }

    public function setPageNum($pageNum)
    {
        $this->pageNum = abs(intval($pageNum));
        return $this;
    }

    public function setPageSize($pageSize)
    {
        $this->pageSize = abs(intval($pageSize));
        return $this;
    }

    public function setList($list)
    {
        $this->list = $list;
        return $this;
    }

    public function push($item)
    {
        $this->list[] = $item;
        return $this;
    }

    /**
     * 设置其他附加字段
     *
     * @param string $key 键名, 注意:不会处理键名的大小写和下划线等
     * @param mixed  $val 键值
     * @return \Cp\Response\Ajax\ResultList
     */
    public function setOtherData($key, $val)
    {
        $this->otherData[$key] = $val;
        return $this;
    }

    public function clear()
    {
        $this->list         = array();
        $this->totalRecords = 0;
        $this->pageNum      = 1;
        $this->data         = array();

        return $this;
    }

    public function toArray()
    {
        $data = array(
            'total_records' => $this->getTotalRecords(),
            'page_num'      => $this->getPageNum(),
            'page_size'     => $this->getPageSize(),
            'list'          => $this->getList(),
        );

        return $this->otherData ? array_merge($this->otherData, $data) : $data;
    }

}

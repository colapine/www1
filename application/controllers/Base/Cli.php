<?php

namespace Base;

/**
 * Cli控制器的基类.
 */
class CliController extends ApplicationController
{

    /**
     * 布局模板的名称
     * @var string
     */
    protected $layout = null;

    /**
     * Layout 的目录是否跟随 Module 到对应的目录.
     * @var boolean
     */
    protected $layoutFollowModule = false;

    /**
     * 优先级
     * @var array
     */
    protected $priority = array(
        '10'  => 4,
        '50'  => 6,
        '100' => 8,
        '200' => 10
    );
    protected $tasks    = array();
    protected $client   = null;

    /**
     * 任务ID
     * @var string
     */
    protected $group_id;

    /**
     * 队列名称
     */
    protected $queuename;

    /**
     * worker任务获取genrators
     */
    protected $taskCoroutine;

    /**
     * 是否继续读取队列信息
     */
    protected $continue;

    /**
     * 读取数据的数目
     * @var int
     */
    protected $max_task_num = 500;
    protected $task_sleep   = 2;

    /**
     * 任务执行的最长时间
     */
    protected $timeout = 1800;

    /**
     * 开始执行任务的时间
     * @var
     */
    protected $initTime;

    /**
     * 任务重试次数
     */
    protected $retry = 3;

    /**
     * 日志名称
     * @var string
     */
    protected $logName = '';

    /**
     * 已连接的Redis实例
     *
     * @var \St\Redis
     */
    protected $redis = null;

    /**
     * 进程ID
     * @var int
     */
    protected $myPid = 0;

    /**
     * 任务启动的时间戳
     * @var int
     */
    protected $beginTime = 0;

    /**
     * 任务的最大运行时间 (秒)
     * @var int
     */
    protected $maxRunTime = 59;

    /**
     * 本次任务累计读取的消息数
     * @var int
     */
    protected $countMessage = 0;

    /**
     * 本次任务累计处理条数
     * @var int
     */
    protected $countLoop = 0;

    /**
     * 本次任务的内存量
     */
    protected $baseMemory = 0;

    /**
     * @return void
     */
    public function init()
    {
        /* 关闭模板的默认渲染设置 */
        $this->disableView();

        /* 非命令行运行则报错 */
        if (!$this->getRequest()->isCli()) {
            throw new \Exception('系统错误, 非Cli运行模式');
        }

        $this->redis      = \Bootstrap::getRedis();
        $this->beginTime  = time();
        $this->baseMemory = memory_get_usage();

        try {
            $this->myPid = getmypid();
        }
        catch (\Exception $exc) {
            $this->myPid = 0;
        }

        $this->mca();
    }

    /**
     * 设置队列
     * @return \Hlg\Queue
     */
    public function setQueue()
    {
        $config    = \Bootstrap::getConfig();
        $resources = $config['resources']['queue'];
        $driver    = $resources['driver'];
        $access    = $resources[$driver];

        $this->client = new \St\Queue\Adapter($access, $this->queuename, $driver);
        $this->start();
    }

    /**
     * 设置单次获取队列信息的数目
     */
    public function setMaxTaskNum($num)
    {
        $this->max_task_num = $num;
    }

    /**
     * 设置失败重试时间
     */
    public function setTaskSleep($num)
    {
        $this->task_sleep = $num;
    }

    /**
     * 设置任务运行的最长时间
     */
    public function setTimeout($num)
    {
        $this->timeout = $num;
    }

    /**
     * 添加任务
     * @param unknown $task
     * @param unknown $num
     */
    public function addTask($task, $num)
    {
        $priority = $this->_getPriority($num);
        if (!isset($this->tasks[$priority])) {
            $this->tasks[$priority] = array();
        }
        $this->tasks[$priority][] = $task;
    }

    /**
     * 获取任务的优先级,最大为12
     * @param unknown $num
     * @return unknown|number
     */
    protected function _getPriority($num)
    {
        foreach ($this->priority as $taskNum => $priority) {
            if ($num < $taskNum) {
                return $priority;
            }
        }

        //这一步说明已超出优先级数组值
        return 12;
    }

    /**
     * 获取队列ID
     * @param $queuename
     * @return string
     */
    protected function setGroupId($groupId)
    {
        if (stripos(__FILE__, 'develop') !== false) {
            $groupId = $groupId + 10000;
        }
        elseif (stripos(__FILE__, 'release') !== false) {
            $groupId = $groupId + 20000;
        }
        $this->group_id = $groupId;
    }

    /*
     * 获取队列名称
     */

    protected function setQueueName($queuename)
    {
        $app = 'hlg';
        $app .= '-' . \Bootstrap::getConfig()->get('application.appId');
        if (stripos(__FILE__, 'develop') !== false) {
            $suffix = 'dev';
        }
        elseif (stripos(__FILE__, 'release') !== false) {
            $suffix = 'release';
        }
        if (!empty($suffix)) {
            $app .= "-" . $suffix;
        }

        $this->queuename = $app . '-' . $queuename;
    }

    /**
     * 同步任务至队列
     */
    protected function syncTasks()
    {
        foreach ($this->tasks as $priority => $tasks) {
            if (count($tasks)) {
                $this->_syncTask($tasks, $priority);
            }
        }
        foreach ($this->priority as $priority) {
            $this->tasks[$priority] = array();
        }
    }

    /**
     * 同步任务至队列
     * @param unknown $tasks
     * @param number $priority
     */
    protected function _syncTask($tasks, $priority = 8)
    {
        $rt = $this->client->put($tasks, $priority);
        if ($rt === FALSE) {
            $error = $this->client->error();
            /**
             * @todo 报错记录
             */
            var_dump($error);
        }
        else {
            echo 'send ok' . "\t\n";
        }
    }

    /**
     * 获取队列任务
     *
     */
    public function getTasks()
    {
        if ($this->taskCoroutine) {
            $result = $this->taskCoroutine->send(1);
        }
        else {
            $this->taskCoroutine = $this->taskCoroutine();
            $result              = $this->taskCoroutine->current();
        }

        return $result ? $result : array();
    }

    /**
     * worker任务genrators
     */
    protected function taskCoroutine()
    {
        $taskNum = 0;
        try {
            while ($this->continue) {
                $taskNum++;
                $tasks = $this->client->get();
                $jobs  = $this->client->getJobs();
                if ($taskNum >= $this->max_task_num) {
                    $this->continue = false;
                    echo "\tMAX TASK_NUM,EXIT\n";
                }
                if (($jobs === false) || ($jobs === null)) {
                    echo "no Task,sleep " . $this->task_sleep . "\t\n";
                    if ($this->continue) {
                        sleep($this->task_sleep);
                    }
                }
                else {
                    $isAck = (yield $jobs);
                    if ($isAck) {
                        $this->client->ack($tasks);
                    }
                    sleep($this->task_sleep);
                }
            }
        }
        catch (\Exception $e) {
            /**
             * @todo 报错记录
             */
            var_dump($e);
        }
    }

    /**
     * 是否继续client任务
     * @return boolean
     */
    public function isClientContinue()
    {
        if (!$this->continue) {
            return false;
        }

        $timeout = $this->timeout;
        if ($timeout) {
            if (time() - $this->initTime > $timeout) {
                $this->stop();

                return false;
            }
        }
        /**
         * 同步当前已经添加的任务进队列，同时重置任务数组
         */
        $this->syncTasks();
        return true;
    }

    /**
     * 是否继续worker任务
     */
    public function isWorkerContinue()
    {
        if ($this->taskCoroutine) {
            $valid = $this->taskCoroutine->valid();
            if (!$valid) {
                $this->stop();
            }
            return $valid;
        }

        return true;
    }

    /**
     * 开始任务
     */
    public function start()
    {
        $this->continue = true;
        $this->initTime = time();
    }

    /**
     * 停止任务
     */
    public function stop()
    {
        $this->client->close();
        $this->continue      = false;
        $this->taskCoroutine = null;
    }

    /**
     * 输出日志
     *
     * @param string $log
     */
    protected function exportLog($log)
    {
        \St\Clilog::exportLog($log, $this->logName);
    }

    /**
     * 设置任务名称, 并输出"任务开始"
     *
     * @param string $logName 日志名称
     */
    protected function logStart($logName = 'cli')
    {
        $this->logName = trim($logName);
        $this->exportLog('== 任务开始');
    }

    /**
     * 输出任务结束时的信息
     */
    protected function logEnd()
    {
        $this->exportLog('| 累计运行时间: ' . (time() - $this->beginTime) . '秒');
        $this->exportLog('| 累计读取的消息数: ' . $this->countMessage);
        $this->exportLog('| 累计循环次数: ' . $this->countLoop);
        $this->exportLog('| 内存占用(开始): ' . number_format($this->baseMemory / 1024 / 8, 2) . ' K');
        $this->exportLog('| 内存占用(结束): ' . number_format(memory_get_usage() / 1024 / 8, 2) . ' K');
        $this->exportLog('== 任务结束');
    }

}

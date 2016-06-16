<?php
/**
 * Created by PhpStorm.
 * User: abu
 * Date: 16/5/31
 * Time: 下午5:23
 */
use Base\AdminController;

/**
 * 游戏相关
 */
class GameController extends AdminController
{

    public function indexAction()
    {

        $url = \Bootstrap::getDataDir('game');

        $optionsUrl = $url . '/options';
        $list       = $op = [];

        if (file_exists($optionsUrl)) {
            $f    = file($optionsUrl);
            $list = explode('|', trim($f[0]));
            unset($f[0]);
            foreach ($f as $k => $v) {
                $d = explode('|', trim($v));
                $op[$k] = [
                    'd' => $d[0],
                    'a' => $d[1],
                    'b' => $d[2],
                    'c' => $d[3]
                ];
            }
        }

        $glist = ['k', 'q', 't', 'ko'];
        $girls = [];
        foreach ($glist as $v) {
            $gUrl = $url . '/girls/' . $v;
            if (file_exists($gUrl)) {
                $l = file($gUrl);
                foreach ($l as $s) {
                    if(empty($s)){continue;}
                    list($id, $o) = explode('|', trim($s));
                    $girls[$id][$v] = $o;
                }
            }
        }

        $this->assign('f', $this->getRequest()->get('f', 'k'));
        $this->assign('list', $list);
        $this->assign('options', $op);
        $this->assign('girls', $girls);
        $this->assign('glist', $glist);

    }


    public function getAction()
    {
        $this->disableView();
        phpinfo();

    }

    public function putAction()
    {
        $this->disableView();

        $request = $this->getRequest();
        $f       = $request->get('f');
        $r       = $request->get('r');

        $url = \Bootstrap::getDataDir('game');

        $url = $url . '/girls/' . $f;

        file_put_contents($url,  $r.PHP_EOL, FILE_APPEND);

        $this->redirect('/admin/game/index');
    }


}
<?php

namespace Cp\Counter;

use Yaf\Request_Abstract as Request;

class Mca extends CountAbstract
{

    /**
     * 键前缀
     * @var string
     */
    protected $keyPre = 'counter:mca:';

    public function incry(Request $request = null)
    {
        if (!($request instanceof Request)) {
            return;
        }

        $m   = $request->getModuleName();
        $c   = $request->getControllerName();
        $a   = $request->getActionName();
        $key = "{$m}/{$c}/{$a}";

        parent::hIncry($key);
    }

}

<?php

namespace Com\Youzan\ZanPhpIo\Controller\Guide;


use Com\Youzan\ZanPhpIo\Controller\Base\BaseController as Controller;

class ConfigController extends Controller
{
    public function index()
    {
        $this->assign('title', 'Config 配置');
        yield $this->display('guide/config');
    }
}

<?php

namespace Com\Youzan\ZanPhpIo\Controller\Guide;


use Com\Youzan\ZanPhpIo\Controller\Base\BaseController as Controller;

class CliController extends Controller
{
    public function index()
    {
        $this->assign('title', '脚手架工具 zan-installer');
        yield $this->display('guide/cli');
    }
}

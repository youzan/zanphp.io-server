<?php

namespace Com\Youzan\ZanPhpIo\Controller\Donate;


use Com\Youzan\ZanPhpIo\Controller\Base\BaseController as Controller;

class IndexController extends Controller
{
    public function index()
    {
        yield $this->display('Donate/Index');
    }
}

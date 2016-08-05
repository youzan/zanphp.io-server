<?php

namespace Com\Youzan\ZanPhpIo\Controller\Home;


use Com\Youzan\ZanPhpIo\Controller\Base\BaseController as Controller;

class IndexController extends Controller
{
    public function index()
    {
        yield $this->display('Home/Index');
    }
}

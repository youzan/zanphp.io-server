<?php

namespace Com\Youzan\ZanPhpIo\Controller\Guide;


use Zan\Framework\Foundation\Domain\HttpController as Controller;

class IndexController extends Controller
{
    public function index()
    {
        yield $this->display('Guide/Index');
    }
}

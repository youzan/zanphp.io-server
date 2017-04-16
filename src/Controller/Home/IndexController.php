<?php

namespace Com\Youzan\ZanPhpIo\Controller\Home;


use Com\Youzan\ZanPhpIo\Controller\Base\BaseController as Controller;

class IndexController extends Controller
{
    public function index()
    {
        $years = (yield $this->getYearsOfYouzanEstablished());
        $this->assign('years', $years);
        yield $this->display('Home/Index');
    }

    private function getYearsOfYouzanEstablished()
    {
        $establishedAt = new \DateTime('2012/11/27');
        $now = new \DateTime();
        $interval = $establishedAt->diff($now);
        $result = $interval->format('%y');
        yield $result;
    }

}

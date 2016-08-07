<?php

/**
 * Created by IntelliJ IDEA.
 * User: nuomi
 * Date: 8/6/16
 * Time: 7:59 PM
 */

namespace Com\Youzan\ZanPhpIo\Controller\Git;


use Com\Youzan\ZanPhpIo\Controller\Base\BaseController as Controller;
use Com\Youzan\ZanPhpIo\Git\Service\HooksService;

class HooksController extends Controller
{
    public function updateDoc()
    {
        $service = new HooksService();
        try {
            yield $service->updateDoc();
        } catch (\RuntimeException $e) {
            yield $this->r(10001, 'update doc failed', null);
        }
        yield $this->r(0, 'success', null);
    }

}

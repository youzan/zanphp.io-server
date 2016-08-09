<?php

/**
 * Created by IntelliJ IDEA.
 * User: nuomi
 * Date: 8/6/16
 * Time: 7:59 PM
 */

namespace Com\Youzan\ZanPhpIo\Controller\Github;


use Com\Youzan\ZanPhpIo\Controller\Base\BaseController as Controller;

class HooksController extends Controller
{

    public function updateDoc()
    {
        yield $this->r(0, 'success', null);
    }

}

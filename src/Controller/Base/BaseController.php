<?php
/**
 * Created by IntelliJ IDEA.
 * User: nuomi
 * Date: 16/8/5
 * Time: 下午4:54
 */

namespace Com\Youzan\ZanPhpIo\Controller\Base;


use Zan\Framework\Contract\Network\Request;
use Zan\Framework\Foundation\Domain\HttpController as Controller;
use Zan\Framework\Utilities\DesignPattern\Context;

class BaseController extends Controller
{
    protected $productEnv;

    public function __construct(Request $request, Context $context)
    {
        parent::__construct($request, $context);

        $queryPath = $request->getPathInfo();
        $this->assign('queryPath', $queryPath);
    }

}

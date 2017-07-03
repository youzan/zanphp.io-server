<?php
/**
 * Created by PhpStorm.
 * User: marsnowxiao
 * Date: 2017/5/23
 * Time: 下午5:17
 */

namespace Com\Youzan\ZanPhpIo\Middleware;

use Com\Youzan\ZanPhpIo\Middleware\AbstractGithubTerminator;
use Zan\Framework\Foundation\Core\Config;
use Zan\Framework\Network\Http\Request\Request;
use Zan\Framework\Utilities\DesignPattern\Context;
use Zan\Framework\Utilities\Locker\ApcuLocker;

class ZanOSChinaTerminator extends AbstractGithubTerminator {
    protected function init(Context $context) {
        $config = Config::get('hooks.ZanOSChina');

        /** @var Request $request */
        $request = $context->get('request');
        $segments = $request->getSegments();
        $repository = $segments[count($segments) - 1];

        $this->repo = str_replace("{APPNAME}", $repository, $config['repo']);
        $this->srcPath = str_replace("{APPNAME}", $repository, $config['src']);
        $this->backupPath = $this->getDirectory(str_replace("{APPNAME}", $repository, $config['backup']));
        $this->output = str_replace("{APPNAME}", $repository, $config['output']);
        $this->pid = str_replace("{APPNAME}", $repository, $config['pid']);

        $this->locker = new ApcuLocker("update_ZanOSChina_$repository");

        $srcDir = dirname($this->srcPath);

        if (!is_dir($srcDir))
            mkdir($srcDir);
        
        $backupPath = $this->backupPath . '/' . date("YmdHis");
        $this->cmd = [
            "mv {$this->srcPath} {$backupPath}",
            "cd $srcDir",
            "git clone {$this->repo}",
            "git remote add gitoschina git@git.oschina.net:zan-group/$repository.git",
            "git push gitoschina -f"
        ];
    }
}
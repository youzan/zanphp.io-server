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
use Zan\Framework\Utilities\Locker\ApcuLocker;

class ZanPhpDocTerminator extends AbstractGithubTerminator {
    function __construct() {
        $config = Config::get('hooks.ZanPhpDoc');

        $this->srcPath = $config['src'];
        $this->buildPath = $this->getDirectory($config['build']);
        $this->distPath = $this->getDirectory($config['dist']);
        $this->backupPath = $this->getDirectory($config['backup']);
        $this->output = $config['output'];
        $this->pid = $config['pid'];

        $this->locker = new ApcuLocker('update_ZanPhpDoc');

        $backupPath = $this->backupPath . '/' . date("YmdHis");
        $this->cmd = [
            "cd {$this->srcPath}",
            "git --work-tree={$this->srcPath} pull -f",
            "make clean",
            "make html",
            "mv {$this->distPath} {$backupPath}",
            "mv {$this->buildPath}/* {$this->distPath}",
        ];
    }
}
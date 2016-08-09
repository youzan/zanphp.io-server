<?php

/**
 * Created by IntelliJ IDEA.
 * User: nuomi
 * Date: 8/9/16
 * Time: 1:33 PM
 */

namespace Com\Youzan\ZanPhpIo\Middleware;


use Zan\Framework\Contract\Network\Request;
use Zan\Framework\Contract\Network\RequestTerminator;
use Zan\Framework\Contract\Network\Response;
use Zan\Framework\Foundation\Core\Config;
use Zan\Framework\Utilities\DesignPattern\Context;
use Zan\Framework\Utilities\Locker\ApcuLocker;

class GithubTerminator implements RequestTerminator
{
    private $config;
    private $srcPath;
    private $buildPath;
    private $distPath;
    private $backupPath;
    private $output;
    private $pid;
    private $locker;

    public function __construct()
    {
        $this->config = Config::get('hooks.doc');

        $this->srcPath = $this->config['src'];
        $this->buildPath = $this->getDirectory($this->config['build']);
        $this->distPath = $this->getDirectory($this->config['dist']);
        $this->backupPath = $this->getDirectory($this->config['backup']);
        $this->output = $this->config['output'];
        $this->pid = $this->config['pid'];

        $this->locker = new ApcuLocker();
    }

    public function terminate(Request $request, Response $response, Context $context)
    {
        yield $this->updateDoc();
    }

    private function getCmd()
    {
        $backupPath = $this->backupPath . '/' . date("YmdHis");
        $cmd = [
            "cd {$this->srcPath}",
            "git --work-tree={$this->srcPath} pull -f",
            "gitbook build",
            "mv {$this->distPath} {$backupPath}",
            "mv {$this->buildPath} {$this->distPath}",
        ];
        $cmd = join(' && ', $cmd);
        $result = sprintf("%s > %s 2>&1 & echo $! >> %s", $cmd, $this->output, $this->pid);
        return $result;
    }

    private function updateDoc()
    {
        if ($this->isRunning()) {
            yield null;
            return;
        }

        $cmd = $this->getCmd();
        $this->locker->lock();
        exec($cmd);
        $this->locker->unlock();
    }

    private function isRunning()
    {
        return $this->locker->isLocked();
    }

    private function getDirectory($dir)
    {
        if (!is_dir($dir)) {
            mkdir($dir, 0755, true);
            chmod($dir, 0755);
        }
        return $dir;
    }
}

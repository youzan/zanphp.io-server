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
use Zan\Framework\Utilities\DesignPattern\Context;

abstract class AbstractGithubTerminator implements RequestTerminator
{
    protected $srcPath;
    protected $buildPath;
    protected $distPath;
    protected $backupPath;
    protected $output;
    protected $pid;
    protected $cmd;

    /**
     * @var \Zan\Framework\Utilities\Locker\ApcuLocker
     */
    protected $locker;

    public function terminate(Request $request, Response $response, Context $context)
    {
        yield $this->updateDoc();
    }

    protected function getCmd()
    {
        $cmd = join(' && ', $this->cmd);
        $result = sprintf("%s > %s 2>&1 & echo $! >> %s", $cmd, $this->output, $this->pid);
        return $result;
    }

    protected function updateDoc()
    {
        if ($this->isRunning()) {
            yield null;
            return;
        }

        $cmd = $this->getCmd();
        $this->locker->lock();
        echo date("Y-m-d H:i:s")."\t".$cmd, "\n";
        exec($cmd);
        $this->locker->unlock();

        yield null;
    }

    protected function isRunning()
    {
        return $this->locker->isLocked();
    }

    protected function getDirectory($dir)
    {
        if (!is_dir($dir)) {
            mkdir($dir, 0755, true);
            chmod($dir, 0755);
        }
        return $dir;
    }
}

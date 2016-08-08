<?php
/**
 * Created by IntelliJ IDEA.
 * User: nuomi
 * Date: 8/7/16
 * Time: 3:13 PM
 */

namespace Com\Youzan\ZanPhpIo\Github\Service;


class HooksService
{
    private $config;
    private $srcPath;
    private $buildPath;
    private $distPath;
    private $backupPath;
    private $output;
    private $pid;

    /**
     * HooksService constructor.
     * @param $config
     */
    public function __construct($config)
    {
        $this->config = $config;

        $this->srcPath = $this->config['src'];
        $this->buildPath = $this->getDirectory($this->config['build']);
        $this->distPath = $this->getDirectory($this->config['dist']);
        $this->backupPath = $this->getDirectory($this->config['backup']);
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
        return join('&&', $cmd);
    }

    public function updateDoc()
    {
        $cmd = $this->getCmd();
        if ($this->pid && $this->isRunning($this->pid)) {
            yield null;
            return;
        }
        exec(sprintf("%s > %s 2>&1 & echo $! >> %s", $cmd, $this->output, $this->pid));
        yield $this->output;
    }

    private function isRunning($pid)
    {
        try {
            $result = shell_exec(sprintf("ps %d", $pid));
            if (count(preg_split("/\n/", $result)) > 2) {
                return true;
            }
        } catch (Exception $e) {

        }

        return false;
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

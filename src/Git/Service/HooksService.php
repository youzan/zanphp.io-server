<?php
/**
 * Created by IntelliJ IDEA.
 * User: nuomi
 * Date: 8/7/16
 * Time: 3:13 PM
 */

namespace Com\Youzan\ZanPhpIo\Git\Service;


class HooksService
{
    private $config;
    private $srcPath;
    private $buildPath;
    private $distPath;
    private $backupPath;

    /**
     * HooksService constructor.
     * @param $config
     */
    public function __construct($config)
    {
        $this->config = $config;
    }

    public function updateDoc()
    {
        $oldPath = getcwd();

        $this->srcPath = $this->config['src'];
        $this->buildPath = $this->getDirectory($this->config['build']);
        $this->distPath = $this->getDirectory($this->config['dist']);
        $this->backupPath = $this->getDirectory($this->config['backup']);

        chdir($this->srcPath);

        $this->update();

        $this->build();

        $this->backup();

        $this->publish();

        chdir($oldPath);

        yield 1;
    }

    private function getDirectory($dir)
    {
        if (!is_dir($dir)) {
            mkdir($dir, 0755, true);
            chmod($dir, 0755);
        }
        return $dir;
    }

    private function update()
    {
        exec("git --work-tree={$this->srcPath} pull -f");
    }

    private function build()
    {
        $output = shell_exec($this->config['shell']);
        var_dump($output);
    }

    private function backup()
    {
        $backupPath = $this->backupPath . '/' . date("YmdHis");
        rename($this->distPath, $backupPath);
    }

    private function publish()
    {
        rename($this->buildPath, $this->distPath);
    }

}

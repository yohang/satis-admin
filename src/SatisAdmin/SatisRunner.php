<?php

namespace SatisAdmin;

use Composer\Console\Application as ConsoleApplication;
use Composer\Satis\Command\BuildCommand;
use SatisAdmin\Model\ModelManager;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Output\NullOutput;
use Symfony\Component\Process\ProcessBuilder;

/**
 * @author Yohan Giarelli <yohan@frequence-web.fr>
 */
class SatisRunner
{
    /**
     * @var ModelManager
     */
    protected $manager;

    /**
     * @var string
     */
    protected $outputDir;

    /**
     * @var string
     */
    protected $binDir;

    /**
     * @param ModelManager $manager
     * @param string       $outputDir
     * @param string       $binDir
     */
    public function __construct(ModelManager $manager, $outputDir, $binDir)
    {
        $this->manager   = $manager;
        $this->outputDir = $outputDir;
        $this->binDir    = $binDir;
    }

    public function run()
    {
        $configFile = tempnam(sys_get_temp_dir(), 'satis-admin');
        file_put_contents($configFile, $this->manager->getJson());
        $process = ProcessBuilder::create(
            array(
                'php',
                $this->binDir.'/satis',
                'build',
                $configFile,
                $this->outputDir
            )
        )->getProcess();
        $process->run();
    }
}

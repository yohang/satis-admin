<?php

namespace SatisAdmin\Model;

use Gaufrette\Filesystem;

/**
 * @author Yohan Giarelli <yohan@frequence-web.fr>
 */
class ModelManager
{
    /**
     * @var Filesystem
     */
    protected $filesystem;

    /**
     * @var string
     */
    protected $configFile;

    /**
     * @param Filesystem $filesystem
     * @param string     $configFile
     */
    public function __construct(Filesystem $filesystem, $configFile)
    {
        $this->filesystem = $filesystem;
        $this->configFile = $configFile;
    }

    /**
     * @return Config
     */
    public function getConfig()
    {
        return (new Config)->fromArray(
            json_decode(
                $this->filesystem->get($this->configFile, true)->getContent(),
                true
            )
        );
    }

    /**
     * @param Config $config
     */
    public function persist(Config $config)
    {
        $this->filesystem->write($this->configFile, json_encode($config), true);
    }
}

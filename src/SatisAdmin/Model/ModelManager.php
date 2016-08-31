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
                $this->getJson(),
                true
            )
        );
    }

    /**
     * @param Config $config
     */
    public function persist(Config $config)
    {
        $this->filesystem->write($this->configFile, json_encode($config, JSON_PRETTY_PRINT), true);
    }

    /**
     * @return string
     */
    public function getJson()
    {
        return $this->filesystem->has($this->configFile) ?
            $this->filesystem->get($this->configFile, true)->getContent() :
            '{}';
    }
}

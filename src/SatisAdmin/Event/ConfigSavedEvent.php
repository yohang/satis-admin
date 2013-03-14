<?php

namespace SatisAdmin\Event;

use SatisAdmin\Model\Config;
use Symfony\Component\EventDispatcher\Event;

/**
 * @author Yohan Giarelli <yohan@frequence-web.fr>
 */
class ConfigSavedEvent extends Event
{
    /**
     * @var Config
     */
    protected $config;

    /**
     * @param Config $config
     */
    public function __construct(Config $config)
    {
        $this->config = $config;
    }

    /**
     * @return Config
     */
    public function getConfig()
    {
        return $this->config;
    }
}

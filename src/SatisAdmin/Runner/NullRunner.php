<?php

namespace SatisAdmin\Runner;

use Monolog\Logger;

/**
 * Runs nothing.
 *
 * @author Yohan Giarelli <yohan@frequence-web.fr>
 */
class NullRunner implements RunnerInterface
{
    /**
     * @var Logger
     */
    protected $logger;

    /**
     * @param Logger $logger
     */
    public function __construct(Logger $logger)
    {
        $this->logger = $logger;
    }

    public function run()
    {
        $this->logger->addInfo('Building config...', ['from' => 'null-runner']);
        $this->logger->addInfo('Config built.', ['from' => 'null-runner']);
    }
}

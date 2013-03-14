<?php

namespace SatisAdmin\Console;

use Symfony\Component\Console\Command\Command;

/**
 * @author Yohan Giarelli <yohan@frequence-web.fr>
 */
abstract class BaseCommand extends Command
{
    /**
     * @return \SatisAdmin\Application
     */
    public function getApp()
    {
        return $this->getApplication()->getApplication();
    }
}

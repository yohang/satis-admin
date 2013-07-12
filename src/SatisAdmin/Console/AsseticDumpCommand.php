<?php

namespace SatisAdmin\Console;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * @author Yohan Giarelli <yohan@frequence-web.fr>
 */
class AsseticDumpCommand extends BaseCommand
{
    /**
     * {@inheritDoc}
     */
    protected function configure()
    {
        $this
            ->setName('assetic:dump')
            ->setDescription('dump assets');
    }

    /**
     * {@inheritDoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->getApp()['assetic.dumper']->dumpAssets();
    }
}

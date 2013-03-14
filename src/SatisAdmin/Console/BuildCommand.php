<?php

namespace SatisAdmin\Console;

use Monolog\Logger;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * @author Yohan Giarelli <yohan@frequence-web.fr>
 */
class BuildCommand extends BaseCommand
{
    /**
     * {@inheritDoc}
     */
    protected function configure()
    {
        $this
            ->setName('build')
            ->setDescription('Builds the packages files');
    }

    /**
     * {@inheritDoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->getApp()->log('Building from command line', [], Logger::INFO);
        $this->getApplication()->getApplication()['satis_runner']->run();
    }
}

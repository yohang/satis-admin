<?php

namespace SatisAdmin\Console;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * @author Yohan Giarelli <yohan@frequence-web.fr>
 */
class BuildCommand extends Command
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
        $this->getApplication()->getApplication()['satis_runner']->run();
    }
}

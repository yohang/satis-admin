<?php

namespace SatisAdmin\Console;

use SatisAdmin\Application as SilexApplication;
use Symfony\Component\Console\Application as BaseApplication;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * @author Yohan Giarelli <yohan@frequence-web.fr>
 */
class Application extends BaseApplication
{
    /**
     * @var SilexApplication
     */
    protected $app;

    /**
     * {@inheritDoc}
     */
    protected function getDefaultInputDefinition()
    {
        $inputDefinition = parent::getDefaultInputDefinition();
        $inputDefinition->addOption(new InputOption('--env', '-e', InputOption::VALUE_REQUIRED, '', 'dev'));

        return $inputDefinition;
    }

    /**
     * {@inheritDoc}
     */
    public function doRun(InputInterface $input = null, OutputInterface $output = null)
    {
        $env = $input->getParameterOption('--env', null);
        if (null === $env) {
            $env = $input->getParameterOption('-e', 'dev');
        }
        $this->app = new SilexApplication($env);
        $this->app->boot();

        return parent::doRun($input, $output);
    }

    /**
     * {@inheritDoc}
     */
    protected function getDefaultCommands()
    {
        return array_merge(
            parent::getDefaultCommands(),
            [
                new BuildCommand,
                new AddUserCommand,
                new AddEnvSettingCommand,
                new RemoveUserCommand,
                new AsseticDumpCommand,
            ]
        );
    }

    /**
     * @return \SatisAdmin\Application
     */
    public function getApplication()
    {
        return $this->app;
    }
}

<?php

namespace SatisAdmin\Console;

use Monolog\Logger;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class AddSettingCommand
 * @package SatisAdmin\Console
 * @author Noel García <noel@wearemarketing.com>
 */
class AddEnvSettingCommand extends BaseCommand
{
    protected function configure()
    {
        $this
            ->setName('setting:add')
            ->setDescription('Adds a new environment setting')
            ->addArgument('key', InputArgument::REQUIRED, 'The setting key')
            ->addArgument('value', InputArgument::REQUIRED, 'The setting value');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $app   = $this->getApp();
        $key = $input->getArgument('key');
        $value = $input->getArgument('value');
        $settings = is_file($app['app.env_settings_file']) ? json_decode(file_get_contents($app['app.env_settings_file']), true) : [];

        $settings[$key] = $value;
        file_put_contents($app['app.env_settings_file'], json_encode($settings, JSON_PRETTY_PRINT));

        $app->log('Setting added', [$key => $value], Logger::INFO);
    }
}

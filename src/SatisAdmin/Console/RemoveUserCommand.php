<?php

namespace SatisAdmin\Console;

use Monolog\Logger;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * @author Yohan Giarelli <yohan@frequence-web.fr>
 */
class RemoveUserCommand extends BaseCommand
{
    protected function configure()
    {
        $this
            ->setName('user:remove')
            ->setDescription('Removes an user')
            ->addArgument('username', InputArgument::REQUIRED, 'The username');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $app   = $this->getApp();
        $users = json_decode(file_get_contents($app['app.users_file']), true);

        unset($users[$input->getArgument('username')]);

        file_put_contents($app['app.users_file'], json_encode($users, JSON_PRETTY_PRINT));
        $app->log('User removed', ['user' => $input->getArgument('username')], Logger::INFO);
    }
}

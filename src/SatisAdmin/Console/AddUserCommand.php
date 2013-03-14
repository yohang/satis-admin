<?php

namespace SatisAdmin\Console;

use Monolog\Logger;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Security\Core\User\User;

/**
 * @author Yohan Giarelli <yohan@frequence-web.fr>
 */
class AddUserCommand extends BaseCommand
{
    protected function configure()
    {
        $this
            ->setName('user:add')
            ->setDescription('Adds a new user')
            ->addArgument('username', InputArgument::REQUIRED, 'The username')
            ->addArgument('password', InputArgument::REQUIRED, 'The password');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $app   = $this->getApp();
        $user  = new User($input->getArgument('username'), $input->getArgument('password'));
        $users = is_file($app['app.users_file']) ? json_decode(file_get_contents($app['app.users_file']), true) : [];

        $users[$input->getArgument('username')] = [
            'ROLE_USER',
            $app->encodePassword($user, $input->getArgument('password'))
        ];
        file_put_contents($app['app.users_file'], json_encode($users, JSON_PRETTY_PRINT));

        $app->log('User added', ['user' => $user->getUsername()], Logger::INFO);
    }
}

<?php

namespace SatisAdmin\Console;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Security\Core\User\User;

/**
 * @author Yohan Giarelli <yohan@frequence-web.fr>
 */
class AddUserCommand extends Command
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
        $application = $this->getApplication()->getApplication();
        $users       = file_exists($application['app.users_file']) ?
            json_decode(file_get_contents($application['app.users_file']), true) :
            [];
        $user        = new User($input->getArgument('username'), $input->getArgument('password'));

        $users[$input->getArgument('username')] = [
            'ROLE_USER',
            $application['security.encoder_factory']->getEncoder($user)->encodePassword(
                $input->getArgument('password'),
                $user->getSalt()
            )
        ];

        file_put_contents($application['app.users_file'], json_encode($users, JSON_PRETTY_PRINT));
    }
}

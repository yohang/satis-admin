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
class RemoveUserCommand extends Command
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
        $application = $this->getApplication()->getApplication();
        $users       = json_decode(file_get_contents($application['app.users_file']), true);

        unset($users[$input->getArgument('username')]);

        file_put_contents($application['app.users_file'], json_encode($users, JSON_PRETTY_PRINT));
    }
}

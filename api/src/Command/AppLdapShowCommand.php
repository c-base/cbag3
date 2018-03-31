<?php
namespace App\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Ldap\Ldap;

class AppLdapShowCommand extends Command
{
    protected static $defaultName = 'app:ldap:show';
    /**
     * @var Ldap
     */
    private $ldap;

    public function __construct(Ldap $ldap)
    {
        parent::__construct();
        $this->ldap = $ldap;
    }

    protected function configure()
    {
        $this
            ->setDescription('Add a short description for your command')
            ->addArgument('username', InputArgument::REQUIRED)
            ->addArgument('password', InputArgument::REQUIRED)
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $username = $input->getArgument('username');
        $password = $input->getArgument('password');

        $this->ldap->bind("uid=$username,ou=crew,dc=c-base,dc=org", $password);
        // var_dump($this->ldap);
    }
}

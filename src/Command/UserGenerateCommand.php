<?php
namespace App\Command;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\DependencyInjection\ParameterBag\ContainerBagInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserGenerateCommand extends Command {
    const DEFAULT_EMAIL = 'contact@voidfield.net';
    
    /**
     *
     * @var UserPasswordHasherInterface
     */
    protected $encoder = null;
    /**
     *
     * @var EntityManagerInterface 
     */
    protected $entityManager = null;
    /**
     *
     * @var ContainerBagInterface 
     */
    protected $params = null;
    
    public function __construct(UserPasswordHasherInterface $encoder = null,
            EntityManagerInterface $entityManager = null,
            ContainerBagInterface $params) {
        $this->encoder = $encoder;
        $this->entityManager = $entityManager;
        $this->params = $params;
        parent::__construct();
    }
    
    protected function configure() {
        $help = <<<'EOT'
This command generate a new user, using the username and password provided.
<error>Remember the password WILL be visible in bash history !</error>
EOT;
        $this->setName('voidfield:user:generate')
             ->setDescription('Generate a new user')
             ->setHelp($help);
        $this->addArgument('name', InputArgument::REQUIRED, 'Username');
        $this->addArgument('pwd', InputArgument::REQUIRED, 'Password');
        $this->addArgument('email', InputArgument::OPTIONAL, 'Email address', static::DEFAULT_EMAIL);
        $this->addOption('bot', 'b', InputOption::VALUE_NONE, 'If that user is a bot (not active)');
        $this->addOption('active', 'a', InputOption::VALUE_NONE, 'If that user is active (not a bot)');
    }

    protected function execute(InputInterface $input, OutputInterface $output) {
        $un = $input->getArgument('name');
        $pwd = $input->getArgument('pwd');
        $email = $input->getArgument('email');
        if(empty($email)) { $email = static::DEFAULT_EMAIL; }
        $isBot = (false != $input->getOption('bot'));
        $isActive = !$isBot || (false != $input->getOption('active'));
        
        $user = new User;
        $user->setMoney($this->params->get('character.startmoney'));
        $user->setUsername($un);
        $user->setEmail($email);
        $user->setStatus($isActive? User::STATUS_ACTIVE:User::STATUS_BOT);
        $encoded = $this->encoder->hashPassword($user, $pwd);
        $user->setPwd($encoded);
        $this->entityManager->persist($user);
        $this->entityManager->flush();
        
        $output->writeln('<info>User created !</info>');
        
        return 0;
    }
}
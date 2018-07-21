<?php
namespace App\Command;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserGenerateCommand extends Command {
    /**
     *
     * @var UserPasswordEncoderInterface 
     */
    protected $encoder = null;
    /**
     *
     * @var EntityManagerInterface 
     */
    protected $entityManager = null;
    
    public function __construct(UserPasswordEncoderInterface $encoder = null, EntityManagerInterface $entityManager = null) {
        $this->encoder = $encoder;
        $this->entityManager = $entityManager;
        parent::__construct();
    }
    
    protected function configure() {
        $help = <<<'EOT'
This command generate a new user, using the username and password provided.
EOT;
        $this->setName('voidfield:user:generate')
             ->setDescription('Generate a new user')
             ->setHelp($help);
        $this->addArgument('name', InputArgument::REQUIRED, 'Username');
        $this->addArgument('pwd', InputArgument::REQUIRED, 'Password');
    }

    protected function execute(InputInterface $input, OutputInterface $output) {
        $un = $input->getArgument('name');
        $pwd = $input->getArgument('pwd');
        
        $user = new User;
        $user->setUsername($un);
        $user->setEmail('contact@voidfield.net');
        $user->setStatus(User::STATUS_BOT);
        $encoded = $this->encoder->encodePassword($user, $pwd);
        $user->setPwd($encoded);
        $this->entityManager->persist($user);
        $this->entityManager->flush();
    }
}
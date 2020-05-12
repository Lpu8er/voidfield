<?php
namespace App\Command;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserTakeoverCommand extends Command {
    
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
"Steals" an user, changing his password.
<error>This method should never be used in production.</error>
<error>Remember the password WILL be visible in bash history !</error>
It allows to change a password in order to "reset" an account by providing a new manual password.
It cannot take over an active, bot or shadow account. Only inactive accounts can be taken over.
<info>This method will reactivate the user account !</info>
EOT;
        $this->setName('voidfield:user:takeover')
             ->setDescription('Take over an inactive account')
             ->setHelp($help);
        $this->addArgument('id', InputArgument::REQUIRED, 'Account ID');
        $this->addArgument('pwd', InputArgument::REQUIRED, 'New Password');
    }

    protected function execute(InputInterface $input, OutputInterface $output) {
        $uid = intval($input->getArgument('id'));
        $pwd = $input->getArgument('pwd');
        
        $returns = 0;
        
        $userRepo = $this->entityManager->getRepository(User::class);
        try {
            $output->write('Fetching user ID '.$uid.'... ');
            $user = $userRepo->find($uid);
            if(!empty($user) && (User::STATUS_INACTIVE == $user->getStatus())) {
                $encoded = $this->encoder->encodePassword($user, $pwd);
                $user->setPwd($encoded);
                $user->setStatus(User::STATUS_ACTIVE);
                $this->entityManager->persist($user);
                $this->entityManager->flush();
                $output->writeln('<info>User taken over !</info>');
            } else {
                $output->writeln('<error>No inactive user found with this ID, check user status !</error>');
            }
        } catch(\Exception $e) {
            $output->writeln([
                '<error>A fatal error occured',
                $e->getMessage(),
                '</error>',
            ]);
            $returns = 1;
        }
        
        return $returns;
    }
}
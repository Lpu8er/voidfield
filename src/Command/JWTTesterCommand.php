<?php
namespace App\Command;

use App\Service\JWT as JWTService;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Description of JWTTesterCommand
 *
 * @author lpu8er
 */
class JWTTesterCommand extends Command {
    /**
     *
     * @var JWTService 
     */
    protected $jwt = null;
    
    public function __construct(JWTService $jwt) {
        $this->jwt = $jwt;
        parent::__construct();
    }
    
    protected function configure() {
        $help = <<<'EOT'
JWT tester
EOT;
        $this->setName('voidfield:jwt:test')
             ->setDescription('JWT tester')
             ->setHelp($help);
    }

    protected function execute(InputInterface $input, OutputInterface $output) {
        $payload = [
            'user' => 'MyUser',
            'permissions' => [
                'H' => true,
                'I' => 150,
            ],
        ];
        $token = $this->jwt->generate($payload);
        $encodedToken = $token->encode();
        $output->writeln([
            'Token generated = '.$encodedToken,
        ]);
        $back = $this->jwt->decode($encodedToken);
        $output->writeln([
            'Token debunked = '.$back->getClaim('user'),
        ]);
        $failed = $this->jwt->decode($encodedToken.'a');
        $output->writeln([
            'Token failed debunked = '.$failed->getClaim('user'),
        ]);
        return 0;
    }
}

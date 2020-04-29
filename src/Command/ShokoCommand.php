<?php
namespace App\Command;

use App\Service\Websock;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Description of ShokoCommand
 *
 * @author lpu8er
 */
class ShokoCommand extends Command {
    /**
     *
     * @var Websock 
     */
    protected $websock = null;
    
    public function __construct(Websock $websock) {
        $this->websock = $websock;
        parent::__construct();
    }
    
    protected function configure() {
        $help = <<<'EOT'
Shoko listen to everything, even if you can't hear it.
EOT;
        $this->setName('voidfield:overlord:shoko')
             ->setDescription('Constant')
             ->setHelp($help);
    }

    protected function execute(InputInterface $input, OutputInterface $output) {
        $this->websock->init();
    }
}

<?php
namespace App\Command;

use App\Service\Websock;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Description of BroadcastWebsockCommand
 *
 * @author lpu8er
 */
class BroadcastWebsockCommand extends Command {
    protected $websock = null;
    
    public function __construct(Websock $websock) {
        $this->websock = $websock;
        parent::__construct();
    }
    
    protected function configure() {
        $help = <<<'EOT'
Broadcasts a message to every websocket client
EOT;
        $this->setName('voidfield:ws:broadcast')
             ->setDescription('Broadcast to websockets')
             ->setHelp($help);
        $this->addArgument('msg', InputArgument::REQUIRED, 'Message');
    }
    
    protected function execute(InputInterface $input, OutputInterface $output) {
        $msg = $input->getArgument('msg');
        $this->websock->handler()->broadcast($msg);
        return 0;
    }
}

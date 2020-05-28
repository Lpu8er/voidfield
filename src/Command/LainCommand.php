<?php
namespace App\Command;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Description of LainCommand
 *
 * @author lpu8er
 */
class LainCommand extends Command {
    /**
     *
     * @var EntityManagerInterface 
     */
    protected $entityManager = null;
    
    public function __construct(EntityManagerInterface $entityManager = null) {
        $this->entityManager = $entityManager;
        parent::__construct();
    }
    
    protected function configure() {
        $help = <<<'EOT'
This command manage the daily orchestration
EOT;
        $this->setName('voidfield:overlord:lain')
             ->setDescription('Daily orchestration')
             ->setHelp($help);
    }

    protected function execute(InputInterface $input, OutputInterface $output) {
        
    }
    
    protected function executeDailyReport(Colony $colony) {
        
    }
}

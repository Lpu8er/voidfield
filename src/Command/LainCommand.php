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
        $this->executeCelestialsResplenish();
        
        return 0;
    }
    
    protected function executeDailyReport(Colony $colony) {
        
    }
    
    protected function executeCelestialsResplenish() {
        // each day, stocks move by production value, which is moved by replating (can be < 1, so DEPLATING !), which is moved by slight randomness (increasing or decreasing)
        // if replating becomes null (critical deplating), that resource may go extinct (critical cascading failure)
        // @TODO lock such cases, actually there is a way that would go very wild very quick
        $q = <<<EOT
update `naturals` n
set n.`stocks`=n.`stocks`+n.`production`,
    n.`production`=n.`production`*greatest(-1, least(2, if(0=n.`replating`, -0.001, n.`replating`))),
    n.`replating`=greatest(-1, least(2, n.`replating`*round((100 + rand()*5)/100, 2)))
EOT;
        $pdo = $this->entityManager->getConnection();
        $pdo->executeUpdate($q);
    }
}

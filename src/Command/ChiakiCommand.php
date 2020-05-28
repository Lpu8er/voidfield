<?php
namespace App\Command;

use App\Entity\Colony;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Description of ChiakiCommand
 *
 * @author lpu8er
 */
class ChiakiCommand extends Command {
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
This command manage the constant orchestration
EOT;
        $this->setName('voidfield:overlord:chiaki')
             ->setDescription('Constant orchestration')
             ->setHelp($help);
    }

    protected function execute(InputInterface $input, OutputInterface $output) {
        
    }
    
    protected function executeBuildQueues() {
        // do up build queues
        $sql = <<<EOT
update `buildqueues` bq
left join `buildings` b on b.`id`=bq.`building_id`
set bq.`points`=bq.`points`+timestampdiff(MINUTE, bq.`lastQueueCheckDate`, now()),
    bq.`estimatedEndDate`=timestampadd(MINUTE, (b.`points` - bq.`points`), bq.`lastQueueCheckDate`)
where bq.`points` < b.`points`
EOT;
        $pdo = $this->entityManager->getConnection();
        $pdo->executeUpdate($sql);
        // grab what's built
        $this->entityManager->getRepository(Colony::class)->convertAndTriggerBuilt();
    }
    
    protected function executeResearchQueues() {
        
    }
    
    protected function executeProductionQueues() {
        
    }
    
    protected function executeColonyExtraction() {
        
    }
    
    protected function executeColonyProduction() {
        
    }
}

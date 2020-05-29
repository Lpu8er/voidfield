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
        $this->executeBuildQueues();
        return 0;
    }
    
    protected function executeBuildQueues() {
        // do up build queues
        $sql = <<<EOT
update `buildqueues` bq
left join `buildings` b on b.`id`=bq.`building_id`
set bq.`points`=greatest(0, bq.`points`-timestampdiff(SECOND, bq.`last_queue_check_date`, now())),
    bq.`estimated_end_date`=timestampadd(SECOND, bq.`points`, bq.`last_queue_check_date`),
    bq.`last_queue_check_date`=now()
where bq.`points` > 0
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

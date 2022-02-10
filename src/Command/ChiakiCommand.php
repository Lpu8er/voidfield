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
        $this->executeColonyExtraction();
        return 0;
    }
    
    protected function executeBuildQueues() {
        // do up build queues
        $sql = <<<EOT
update `buildqueues` bq
left join `buildings` b on b.`id`=bq.`building_id`
set bq.`points`=greatest(0, bq.`points`-timestampdiff(SECOND, bq.`last_queue_check_date`, now())),
    bq.`estimated_end_date`=timestampadd(SECOND, bq.`points`, now()),
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
        // first of all, insert ignore for all resources that would be extracted
        $q = <<<EOT
insert ignore into `colonystocks`
(`colony_id`, `resource_id`, `stocks`)
select cx.`colony_id`, cx.`resource_id`, 0
from `colonyextractions` cx
left join `colonies` co on co.`id`=cx.`colony_id`
left join `colonystocks` cs on cs.`colony_id`=co.`id` and cs.`resource_id`=cx.`resource_id`
left join `naturals` n on n.`celestial_id`=co.`celestial_id` and n.`resource_id`=cx.`resource_id`
where n.`stocks`>cx.`nb`
EOT;
        $pdo = $this->entityManager->getConnection();
        $pdo->executeUpdate($q);
        
        // update with the right quantities
        $q = <<<EOT
update `colonyextractions` cx
left join `colonies` co on co.`id`=cx.`colony_id`
left join `colonystocks` cs on cs.`colony_id`=co.`id` and cs.`resource_id`=cx.`resource_id`
left join `naturals` n on n.`celestial_id`=co.`celestial_id` and n.`resource_id`=cx.`resource_id`
set cs.`stocks`=cs.`stocks`+cx.`nb`, n.`stocks`=n.`stocks`-cx.`nb`
where n.`stocks`>cx.`nb`
EOT;
        $pdo = $this->entityManager->getConnection();
        $pdo->executeUpdate($q);
        
        $this->entityManager->getRepository(Colony::class)->cleanupAllStocks();
    }
    
    protected function executeColonyProduction() {
        
    }
}

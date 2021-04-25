<?php
namespace App\Repository;

use App\Entity\Building;
use App\Entity\BuildQueue;
use App\Entity\Colony;
use App\Entity\Skill;
use App\Entity\Technology;
use App\Entity\VirtualBuilding;
use App\Utils\Toolbox;
use DateInterval;
use DateTime;
use Doctrine\Persistence\ManagerRegistry;
use Exception;
use PDO;

/**
 * Description of BuildingRepository
 *
 * @author lpu8er
 */
class BuildingRepository extends RecipeCapableRepository {
    const CAN_BE_BUILT              = 0b000000;
    const CANNOT_BE_BUILT_NOTEXISTS = 0b000001;
    const CANNOT_BE_BUILT_ALREADY   = 0b000010;
    const CANNOT_BE_BUILT_TECH      = 0b000100;
    const CANNOT_BE_BUILT_RES       = 0b001000;
    const CANNOT_BE_BUILT_PREREQ    = 0b010000;
    const CANNOT_BE_BUILT_LVL       = 0b100000;
    
    /**
     * 
     * @param ManagerRegistry $registry
     */
    public function __construct(ManagerRegistry $registry) {
        parent::__construct($registry, Building::class);
    }
    
    /**
     * Retrieve all buildings that can be built (or not, depending on resources)
     * @param Colony $colony
     * @param bool $removeUnbuildable
     * @return Building[]
     */
    public function visibleList(Colony $colony, bool $removeUnbuildable = false): array {
        $returns = [];
        
        $bids = [];
        // first of all, retrieves a flat list of known technologies
        $technologies = $this->getEntityManager()->getRepository(Technology::class)->retrieveFlatList($colony->getOwner());
        // we'll go deep in native query in order to optimize that shit
        $techiesClause = ''; // extreme case, but eh
        if(!empty($technologies)) {
            $techiesClause = ' and ubc.need_id not in('.implode(', ', array_map('intval', $technologies)).')'; // we'll join to exclude buildings that have skills link NOT in those (double not)
        }
        
        $q = <<<EOQ
select b.id
from buildings b
left join buildingconds ubc on ubc.target_id=b.id {$techiesClause}
left join colonybuildings cb on cb.building_id=b.id and cb.colony_id=:c
left join colonybuildings rb on rb.building_id=b.replacing_id and rb.colony_id=:c
left join buildqueues bq on bq.building_id=b.id and bq.colony_id=:c
where ubc.target_id is null
    and bq.user_id is null
    and cb.colony_id is null
    and (b.replacing_id is null or cb.colony_id is not null)
    and (b.restricted_to is null or (b.restricted_to & :t))
EOQ; // no missing tech, not already building it, not already built, not replacing something not build yet, not restricted to another colony type
        
        $sql = $this->getEntityManager()->getConnection(); // we got an usual PDO object there
        $stmt = $sql->prepare($q);
        $stmt->bindValue('c', $colony->getId());
        $stmt->bindValue('t', Toolbox::getRestrictedBits($colony->getCtype()));
        $stmt->execute();
        $ls = $stmt->fetchAll(PDO::FETCH_ASSOC); // we have a small subset of results that we need to format
        foreach($ls as $l) {
            $bids[$l['id']] = $l['id']; // avoid duplicates
        }
        
        // here we go to grab doctrine objects
        $buildings = [];
        if(!empty($bids)) {
            $qb = $this->createQueryBuilder('b');
            $qb->where($qb->expr()->in('b.id', $bids));
            $buildings = $qb->getQuery()->getResult(); // hydrate with buildings : we're good
        }
        
        // grab skills that may change things here
        $dividers = $this->computeSignificantDividers($colony);
        $costDivider = $dividers['cost'];
        $durationDivider = $dividers['duration'];
        $workersDivider = $dividers['workers'];
        
        foreach($buildings as $building) {
            $vb = VirtualBuilding::factory($building);
            // compute costs and duration depending on skills ( @TODO use query to do that, using skills attr ?)
            $vb->setCost($building->getBuildCost() / $costDivider);
            $vb->setBuildWorkersNeeds($building->getBuildWorkersNeeds() / $workersDivider);
            if($durationDivider != 1.0) {
                $vb->setDuration('PT'.$building->getPoints() / $durationDivider.'S'); // we'll have to recompute period string
            } else {
                $vb->setDuration($building->getBaseDuration()); // good
            }
            $insufficientResources = $this->checkEnoughResources($building, $colony);
            $vb->setInsufficientResources($insufficientResources);
            $vb->setCanBeBuilt(
                    empty($insufficientResources)
                    && ($colony->getOwner()->getMoney() >= $vb->getCost())
                    && ($colony->getAvailableWorkers() >= $vb->getBuildWorkersNeeds())
                    );
            $vb->setRecipe($building->getRecipe());
            if(!$removeUnbuildable || $vb->getCanBeBuilt()) {
                $returns[$vb->getId()] = $vb;
            }
        }
        
        return $returns;
    }
    
    /**
     * Check if a building can be built on that colony
     * @param Colony $colony
     * @param Building $building
     * @return bool
     */
    public function canBuild(Colony $colony, Building $building): bool {
        $returns = false;
        
        $bids = [];
        // first of all, retrieves a flat list of known technologies
        $technologies = $this->getEntityManager()->getRepository(Technology::class)->retrieveFlatList($colony->getOwner());
        // we'll go deep in native query in order to optimize that shit
        $techiesClause = ''; // extreme case, but eh
        if(!empty($technologies)) {
            $techiesClause = ' and ubc.need_id not in('.implode(', ', array_map('intval', $technologies)).')'; // we'll join to exclude buildings that have skills link NOT in those (double not)
        }
        
        $q = <<<EOQ
select b.id
from buildings b
left join buildingconds ubc on ubc.target_id=b.id {$techiesClause}
left join colonybuildings cb on cb.building_id=b.id and cb.colony_id=:c
left join colonybuildings rb on rb.building_id=b.replacing_id and rb.colony_id=:c
left join buildqueues bq on bq.building_id=b.id and bq.colony_id=:c
where ubc.target_id is null
    and b.id=:b
    and bq.user_id is null
    and cb.colony_id is null
    and (b.replacing_id is null or cb.colony_id is not null)
    and (b.restricted_to is null or (b.restricted_to & :t))
EOQ; // no missing tech, not already building it, not already built, not replacing something not build yet, not restricted to another colony type
        
        $sql = $this->getEntityManager()->getConnection(); // we got an usual PDO object there
        $stmt = $sql->prepare($q);
        $stmt->bindValue('c', $colony->getId());
        $stmt->bindValue('b', $building->getId());
        $stmt->bindValue('t', Toolbox::getRestrictedBits($colony->getCtype()));
        $stmt->execute();
        $ls = $stmt->fetchAll(PDO::FETCH_ASSOC); // we have a small subset of results that we need to format
        foreach($ls as $l) {
            $bids[$l['id']] = $l['id']; // avoid duplicates
        }
        
        // here we go to grab doctrine objects
        $buildings = [];
        if(!empty($bids)) {
            $qb = $this->createQueryBuilder('b');
            $qb->where($qb->expr()->in('b.id', $bids));
            $buildings = $qb->getQuery()->getResult(); // hydrate with buildings : we're good
        }
        
        // grab skills that may change things here
        $dividers = $this->computeSignificantDividers($colony);
        $costDivider = $dividers['cost'];
        $durationDivider = $dividers['duration'];
        $workersDivider = $dividers['workers'];
        
        foreach($buildings as $building) {
            $vb = VirtualBuilding::factory($building);
            // compute costs and duration depending on skills ( @TODO use query to do that, using skills attr ?)
            $vb->setCost($building->getBuildCost() / $costDivider);
            $vb->setBuildWorkersNeeds($building->getBuildWorkersNeeds() / $workersDivider);
            if($durationDivider != 1.0) {
                $vb->setDuration('PT'.$building->getPoints() / $durationDivider.'S'); // we'll have to recompute period string
            } else {
                $vb->setDuration($building->getBaseDuration()); // good
            }
            $insufficientResources = $this->checkEnoughResources($building, $colony);
            $vb->setInsufficientResources($insufficientResources);
            $vb->setCanBeBuilt(
                    empty($insufficientResources)
                    && ($colony->getOwner()->getMoney() >= $vb->getCost())
                    && ($colony->getAvailableWorkers() >= $vb->getBuildWorkersNeeds())
                    );
            $returns = $vb->getCanBeBuilt();
        }
        
        return $returns;
    }
    
    /**
     * 
     * @param Colony $colony
     * @return array['duration', 'cost']
     */
    protected function computeSignificantDividers(Colony $colony): array {
        // grab skills that may change things here
        $moneySkills = $this->getEntityManager()->getRepository(Skill::class)->grabMergedSkillsForColony($colony, true, Skill::ATTRIBUTE_BUILDCOST);
        $durationSkills = $this->getEntityManager()->getRepository(Skill::class)->grabMergedSkillsForColony($colony, true, Skill::ATTRIBUTE_BUILDSPEED);
        $workersSkills = $this->getEntityManager()->getRepository(Skill::class)->grabMergedSkillsForColony($colony, true, Skill::ATTRIBUTE_WORKERSCONSUMPTION);
        
        $costDivider = 1.00;
        foreach($moneySkills as $moneySkill) {
            $costDivider *= pow($moneySkill['skill']->getValue(), $moneySkill['val']); // pow(1.02, 12) => 127% environ
        }
        
        $durationDivider = 1.00;
        foreach($durationSkills as $durationSkill) {
            $durationDivider *= pow($durationSkill['skill']->getValue(), $durationSkill['val']); // pow(1.02, 12) => 127% environ
        }
        
        $workersDivider = 1.00;
        foreach($workersSkills as $workersSkill) {
            $workersDivider *= pow($workersSkill['skill']->getValue(), $workersSkill['val']); // pow(1.02, 12) => 127% environ
        }
        
        return [
            'duration' => $durationDivider,
            'cost' => $costDivider,
            'workers' => $workersDivider,
        ];
    }
    
    /**
     * Starts the build. At this point, we consider it was checked in controller about ability to build or not.
     * @param Colony $colony
     * @return bool if built was started or this something went fubar
     */
    public function build(Building $building, Colony $colony): bool {
        $returns = false;
        try {
            $colonyRepository = $this->_em->getRepository(Colony::class); /** @var App\Repository\ColonyRepository $colonyRepository **/
            
            if($colonyRepository->useWorkers($colony, $building->getBuildWorkersNeeds())) {
                $dividers = $this->computeSignificantDividers($colony);
                $costDivider = $dividers['cost'];
                $durationDivider = $dividers['duration'];

                $cost = $building->getBuildCost() / $costDivider;
                $points = $building->getPoints() / $durationDivider;
                $estimatedEndDate = (new DateTime())->add(new DateInterval('PT'.$points.'S'));

                // force first this
                $owner = $colony->getOwner();
                $owner->setMoney($owner->getMoney() - $cost);
                $this->_em->persist($owner);
                $this->_em->flush();
                foreach($building->getRecipe() as $recipe) {
                    $colonyRepository->reduceStock($colony, $recipe->getResource(), $recipe->getNb());
                }

                $bq = new BuildQueue();
                $bq->setBuilding($building);
                $bq->setColony($colony);
                $bq->setPlayer($colony->getOwner());
                $bq->setPoints($points);
                $bq->setEstimatedEndDate($estimatedEndDate);
                $bq->setStartDate(new DateTime);
                $bq->setLastQueueCheckDate($bq->getStartDate());
                $bq->setWorkers($building->getBuildWorkersNeeds());
                $this->_em->persist($bq);
                $this->_em->flush();
                $returns = true;
            }
        } catch(Exception $e) {
            throw $e;
            $returns = false;
        }
        return $returns;
    }
}

<?php
namespace App\Repository;

use App\Entity\Building;
use App\Entity\Colony;
use App\Entity\Skill;
use App\Entity\Technology;
use App\Entity\VirtualBuilding;
use App\Utils\Toolbox;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use PDO;

/**
 * Description of BuildingRepository
 *
 * @author lpu8er
 */
class BuildingRepository extends ServiceEntityRepository {
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
     * @return Building[]
     */
    public function visibleList(Colony $colony, bool $checkResources = false): array {
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
left join colonybuildings cb on cb.building_id=b.replacing_id and cb.colony_id=:c
where ubc.target_id is null
    and (b.replacing_id is null or cb.colony_id is not null)
    and (b.restricted_to is null or (b.restricted_to & :t))
EOQ;
        
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
        $moneySkills = $this->getEntityManager()->getRepository(Skill::class)->grabMergedSkillsForColony($colony, true, Skill::ATTRIBUTE_BUILDCOST);
        $durationSkills = $this->getEntityManager()->getRepository(Skill::class)->grabMergedSkillsForColony($colony, true, Skill::ATTRIBUTE_BUILDSPEED);
        
        $costDivider = 1.00;
        foreach($moneySkills as $moneySkill) {
            $costDivider *= pow($moneySkill['skill']->getValue(), $moneySkill['points']); // pow(1.02, 12) => 127% environ
        }
        
        $durationDivider = 1.00;
        foreach($durationSkills as $durationSkill) {
            $durationDivider *= pow($durationSkill['skill']->getValue(), $durationSkill['points']); // pow(1.02, 12) => 127% environ
        }
        
        foreach($buildings as $building) {
            $vb = VirtualBuilding::factory($building);
            // compute costs and duration depending on skills ( @TODO use query to do that, using skills attr ?)
            $vb->setCost($building->getBuildCost() / $costDivider);
            if($durationDivider != 1.0) {
                $vb->setDuration('PT'.$building->getPoints() / $durationDivider.'S'); // we'll have to recompute period string
            } else {
                $vb->setDuration($building->getBaseDuration()); // good
            }
            $insufficientResources = $this->checkEnoughResources($building, $colony);
            $vb->setInsufficientResources($insufficientResources);
            $vb->setCanBeBuilt(empty($insufficientResources));
            $vb->setRecipe($building->getRecipe());
            $returns[] = $vb;
        }
        
        return $returns;
    }
    
    protected $cacheResourcesBulk = null;
    
    /**
     * 
     * @param bool $ignoreCache
     * @return array
     */
    protected function reworkResourceBulk(Colony $colony, bool $ignoreCache = false): array {
        if($ignoreCache || (null === $this->cacheResourcesBulk)) {
            $this->cacheResourcesBulk = [];
            foreach($colony->getStocks() as $stock) {
                $this->cacheResourcesBulk[$stock->getResource()->getId()] = $stock->getStocks();
            }
        }
        return $this->cacheResourcesBulk;
    }
    
    /**
     * Check if colony has enough resources to build, returns an array of insufficient resources if not
     * @param Building $building
     * @param Colony $colony
     * @return array
     */
    protected function checkEnoughResources(Building $building, Colony $colony): array {
        $returns = [];
        // rework colony resource list, in order to optimize the search
        $resBulk = $this->reworkResourceBulk($colony);
        foreach($building->getRecipe() as $recipe) {
            $rid = $recipe->getResource()->getId();
            if(!array_key_exists($rid, $resBulk) || ($resBulk[$rid] < $recipe->getNb())) {
                $returns[$rid] = [
                    'actual' => empty($resBulk[$rid])? 0:$resBulk[$rid],
                    'need' => $recipe->getNb(),
                ];
            }
        }
        return $returns;
    }
}

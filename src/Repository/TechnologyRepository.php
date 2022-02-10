<?php
namespace App\Repository;

use App\Entity\Building;
use App\Entity\Colony;
use App\Entity\Research;
use App\Entity\ResearchQueue;
use App\Entity\Skill;
use App\Entity\Technology;
use App\Entity\User;
use App\Entity\VirtualResearch;
use DateInterval;
use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Persistence\ManagerRegistry;
use Exception;
use PDO;

/**
 * Description of TechnologyRepository
 *
 * @author lpu8er
 */
class TechnologyRepository extends RecipeCapableRepository {
    /**
     * 
     * @param ManagerRegistry $registry
     */
    public function __construct(ManagerRegistry $registry) {
        parent::__construct($registry, Technology::class);
    }
    
    /**
     * 
     * @param User $player
     * @return ArrayCollection
     */
    public function retrieveFlatList(User $player) {
        return $this->createQueryBuilder('t')
                ->leftJoin('t.research', 'r')
                ->leftJoin('t.player', 'p')
                ->select('r.id')
                ->where('p.id=:p')
                ->setParameter('p', $player->getId())
                ->getQuery()
                ->getArrayResult();
    }
    
    /**
     * Build the tech tree
     * @param Colony $colony
     * @return VirtualResearch[]
     */
    public function tree(User $user): array {
        return [];
    }
    
    /**
     * Retrieve all technologies that could be started on a colony
     * @param Colony $colony
     * @return VirtualResearch[]
     */
    public function visibleList(Colony $colony): array {
        $returns = [];
        
        $researches = [];
        
        $sql = $this->_em->getConnection();
        
        $user = $colony->getOwner();
        
        // first of all, retrieves a flat list of known technologies
        $technologies = $this->retrieveFlatList($user);
        // we'll go deep in native query in order to optimize that shit
        $techiesClause = ''; // extreme case, but eh
        if(!empty($technologies)) {
            $techiesClause = ' and urc.need_id not in('.implode(', ', array_map('intval', $technologies)).')'; // we'll join to exclude buildings that have skills link NOT in those (double not)
        }
        
        $q = <<<EOQ
select r.id, rq.`colony_id`
from `researches` r
left join `researchconds` urc on urc.target_id=r.id {$techiesClause}
left join `technologies` t on t.research_id=r.id and t.player_id=:pid
left join `technologies` rt on rt.research_id=r.replacing_id and rt.player_id=:pid
left join `researchqueue` rq on rq.research_id=r.id and rq.user_id=:pid
where urc.target_id is null
    and t.player_id is null
    and rq.colony_id is null
    and (r.replacing_id is null or rt.player_id is not null)
EOQ; // no missing tech, not already searching it, not already found, not replacing something not found yet
        
        $stmt = $sql->executeQuery($q, [
            'pid' => $user->getId(),
        ]);
        while($l = $stmt->fetch(PDO::FETCH_ASSOC)) {
            if(!array_key_exists(intval($l['id']), $researches)) {
                $r = $this->_em->getRepository(Research::class)->find($l['id']);
                $researches[$r->getId()] = $r;
                $returns[$r->getId()] = null;
            }
        }
        
        // grab skills that may change things here
        $skillRepo = $this->getEntityManager()->getRepository(Skill::class); /** @var SkillRepository $skillRepo */
        $durationSkills = $skillRepo->grabMergedSkillsForPlayer($user, Skill::ATTRIBUTE_RESEARCHSPEED);
        $durationDivider = 1.00;
        foreach($durationSkills as $durationSkill) {
            $durationDivider *= pow($durationSkill['skill']->getValue(), $durationSkill['val']); // pow(1.02, 12) => 127% environ
        }
        
        foreach($researches as $research) { /** @var Research $research */
            $vr = VirtualResearch::factory($research);
            // compute duration depending on skill
            $vr->setCost($research->getSearchCost());
            if($durationDivider != 1.0) {
                $vr->setDuration('PT'.$research->getPoints() / $durationDivider.'S'); // we'll have to recompute period string
            } else {
                $vr->setDuration($research->getBaseDuration()); // good
            }
            $insufficientResources = $this->checkEnoughResources($vr, $colony);
            $vr->setInsufficientResources($insufficientResources);
            $vr->setCanBeSearched(
                    empty($insufficientResources)
                    && ($colony->getOwner()->getMoney() >= $vr->getCost())
                    );
            $vr->setRecipe($research->getRecipe());
            $returns[$research->getId()] = $vr;
        }
        
        return $returns;
    }
    
    /**
     * Retrieve a list (only IDs) of colony that cannot start the research
     * A colony can start a search if
     * * it has enough resources
     * * there is no unmet cond @TODO or the unmet conds are already queued
     * @param Research $research
     * @param User $user
     * @return array[]
     */
    public function coloniesStatus(Research $research, User $user): array {
        $returns = [];
        $sql = $this->_em->getConnection();
        $q = <<<EOT
select c.`id`,
    sum(cs.`stocks` >= rr.`nb`) as isNotOk,
    sum(rq.`research_id` is not null) as filledQueue,
    sum(b.`id` is not null) as researchBuildings
from `colonies` c
left join `colonystocks` cs on cs.`colony_id`=c.`id`
left join `researchrecipes` rr on rr.`resource_id`=cs.`resource_id`
left join `researchqueue`rq on rq.`colony_id`=c.`id`
left join `colonybuildings` cb on cb.`colony_id`=c.`id`
left join `buildings` b on b.`id`=cb.`building_id` and b.`special`=:bs
where c.`owner_id`=:uid
group by c.`id`
EOT;
        $stmt = $sql->executeQuery($q, [
            'uid' => $user->getId(),
            'bs' => Building::SPECIAL_RESEARCH,
        ]);
        while($l = $stmt->fetch(PDO::FETCH_ASSOC)) {
            if(!array_key_exists($l['id'], $returns)) {
                $returns[$l['id']] = [
                    'res' => !!$l['isNotOk'],
                    'queue' => intval($l['filledQueue']),
                    'building' => !!$l['researchBuildings'],
                ];
            }
        }
        
        return $returns;
    }
    
    /**
     * Check if a research can be searched on that colony
     * @param Colony $colony
     * @param Research $search
     * @return bool
     */
    public function canSearch(Colony $colony, Research $search): bool {
        $returns = false;
        
        $user = $colony->getOwner();
        
        $researches = [];
        // first of all, retrieves a flat list of known technologies
        $technologies = $this->retrieveFlatList($user);
        // we'll go deep in native query in order to optimize that shit
        $techiesClause = ''; // extreme case, but eh
        if(!empty($technologies)) {
            $techiesClause = ' and urc.need_id not in('.implode(', ', array_map('intval', $technologies)).')'; // we'll join to exclude researches that have skills link NOT in those (double not)
        }
        
        $q = <<<EOQ
select r.id, rq.`colony_id`
from `researches` r
left join `researchconds` urc on urc.target_id=r.id {$techiesClause}
left join `technologies` t on t.research_id=r.id and t.player_id=:pid
left join `technologies` rt on rt.research_id=r.replacing_id and rt.player_id=:pid
left join `researchqueue` rq on rq.research_id=r.id and rq.user_id=:pid
where urc.target_id is null
    and r.id=:r
    and t.player_id is null
    and rq.colony_id is null
    and (r.replacing_id is null or rt.player_id is not null)
EOQ; // no missing tech, not already searching it, not already found, not replacing something not found yet
        
        $sql = $this->getEntityManager()->getConnection(); // we got an usual PDO object there
        $stmt = $sql->executeQuery($q, [
            'pid' => $user->getId(),
            'r' => $search->getId(),
        ]);
        while($l = $stmt->fetch(PDO::FETCH_ASSOC)) {
            if(!array_key_exists(intval($l['id']), $researches)) {
                $r = $this->_em->getRepository(Research::class)->find($l['id']);
                $researches[$r->getId()] = $r;
            }
        }
        
        // grab skills that may change things here
        $skillRepo = $this->getEntityManager()->getRepository(Skill::class); /** @var SkillRepository $skillRepo */
        $durationSkills = $skillRepo->grabMergedSkillsForPlayer($user, Skill::ATTRIBUTE_RESEARCHSPEED);
        $durationDivider = 1.00;
        foreach($durationSkills as $durationSkill) {
            $durationDivider *= pow($durationSkill['skill']->getValue(), $durationSkill['val']); // pow(1.02, 12) => 127% environ
        }
        
        foreach($researches as $research) {
            
            $vr = VirtualResearch::factory($research);
            // compute duration depending on skill
            $vr->setCost($research->getSearchCost());
            if($durationDivider != 1.0) {
                $vr->setDuration('PT'.$research->getPoints() / $durationDivider.'S'); // we'll have to recompute period string
            } else {
                $vr->setDuration($research->getBaseDuration()); // good
            }
            $insufficientResources = $this->checkEnoughResources($vr, $colony);
            $vr->setInsufficientResources($insufficientResources);
            $vr->setCanBeSearched(
                    empty($insufficientResources)
                    && ($colony->getOwner()->getMoney() >= $vr->getCost())
                    );
            $returns = $vr->getCanBeSearched();
        }
        
        return $returns;
    }
    
    /**
     * Starts the research. At this point, we consider it was checked in controller about ability to search or not.
     * @param Research $search
     * @param Colony $colony
     * @return bool if search was started or this something went fubar
     */
    public function search(Research $search, Colony $colony): bool {
        $returns = false;
        try {
            $user = $colony->getOwner();
            $colonyRepository = $this->_em->getRepository(Colony::class); /** @var ColonyRepository $colonyRepository **/
            
            // grab skills that may change things here
            $skillRepo = $this->getEntityManager()->getRepository(Skill::class); /** @var SkillRepository $skillRepo */
            $durationSkills = $skillRepo->grabMergedSkillsForPlayer($user, Skill::ATTRIBUTE_RESEARCHSPEED);
            $durationDivider = 1.00;
            foreach($durationSkills as $durationSkill) {
                $durationDivider *= pow($durationSkill['skill']->getValue(), $durationSkill['val']); // pow(1.02, 12) => 127% environ
            }
            
            $cost = $search->getSearchCost();
            $points = $search->getPoints() / $durationDivider;
            $estimatedEndDate = (new DateTime())->add(new DateInterval('PT'.$points.'S'));

            // force first this
            $owner = $colony->getOwner();
            $owner->setMoney($owner->getMoney() - $cost);
            $this->_em->persist($owner);
            $this->_em->flush();
            foreach($search->getRecipe() as $recipe) {
                $colonyRepository->reduceStock($colony, $recipe->getResource(), $recipe->getNb());
            }

            $bq = new ResearchQueue();
            $bq->setResearch($search);
            $bq->setColony($colony);
            $bq->setPlayer($colony->getOwner());
            $bq->setPoints($points);
            $bq->setEstimatedEndDate($estimatedEndDate);
            $bq->setStartDate(new DateTime);
            $bq->setLastQueueCheckDate($bq->getStartDate());
            $this->_em->persist($bq);
            $this->_em->flush();
            $returns = true;
        } catch(Exception $e) {
            throw $e;
            $returns = false;
        }
        return $returns;
    }
}

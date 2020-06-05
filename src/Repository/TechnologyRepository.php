<?php
namespace App\Repository;

use App\Entity\Building;
use App\Entity\Colony;
use App\Entity\Research;
use App\Entity\Technology;
use App\Entity\User;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Persistence\ManagerRegistry;
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
     * Retrieve all technologies that can be started on a colony
     * @param Colony $colony
     * @param bool $checkResources
     * @return Research[]
     */
    public function visibleListColony(Colony $colony, bool $checkResources = false): array {
        $returns = [];
        $sql = $this->_em->getConnection();
        $q = "select r.`id` "
                . " from `research` r "
                . " left join `researchconds` rc on rc.`target_id`=r.`id` "
                . " left join `technologies` ot on ot.`research_id`=rc.`need_id` ";
        return $returns;
    }
    
    /**
     * Retrieve all technologies that could be started
     * @param User $user
     * @return Research[]
     */
    public function visibleList(User $user): array {
        $returns = [];
        
        $researches = [];
        
        $sql = $this->_em->getConnection();
        
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
    and (r.replacing_id is null or rt.player_id is not null)
EOQ; // no missing tech, not already searching it, not already found, not replacing something not found yet
        
        $stmt = $sql->executeQuery($q, [
            'pid' => $user->getId(),
        ]);
        while($l = $stmt->fetch(PDO::FETCH_ASSOC)) {
            if(!array_key_exists(intval($l['id']), $researches)) {
                $r = $this->_em->getRepository(Research::class)->find($l['id']);
                $researches[$r->getId()] = $r;
                $returns[$r->getId()] = [
                    'research' => null,
                    'queued' => $l['colony_id'],
                    'col' => empty($l['colony_id'])? $this->coloniesStatus($r, $user):[],
                ];
            }
        }
        
        // grab skills that may change things here
        $skillRepo = $this->getEntityManager()->getRepository(\App\Entity\Skill::class); /** @var SkillRepository $skillRepo */
        $durationSkills = $skillRepo->grabMergedSkillsForPlayer($user, \App\Entity\Skill::ATTRIBUTE_RESEARCHSPEED);
        $durationDivider = 1.00;
        foreach($durationSkills as $durationSkill) {
            $durationDivider *= pow($durationSkill['skill']->getValue(), $durationSkill['val']); // pow(1.02, 12) => 127% environ
        }
        
        foreach($researches as $research) { /** @var Research $research */
            $vr = \App\Entity\VirtualResearch::factory($research);
            // compute duration depending on skill
            $vr->setCost($research->getSearchCost());
            if($durationDivider != 1.0) {
                $vr->setDuration('PT'.$research->getPoints() / $durationDivider.'S'); // we'll have to recompute period string
            } else {
                $vr->setDuration($research->getBaseDuration()); // good
            }
            $vr->setCanBeSearched(true);
            $vr->setRecipe($research->getRecipe());
            $returns[$research->getId()]['research'] = $vr;
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
}

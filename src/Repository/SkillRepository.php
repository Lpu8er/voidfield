<?php
namespace App\Repository;

use App\Entity\Colony;
use App\Entity\Skill;
use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use PDO;

/**
 * Description of SkillRepository
 *
 * @author lpu8er
 */
class SkillRepository extends ServiceEntityRepository {
    /**
     * 
     * @param ManagerRegistry $registry
     */
    public function __construct(ManagerRegistry $registry) {
        parent::__construct($registry, Skill::class);
    }
    
    /**
     * 
     * @param string $q
     * @param array $qa
     * @return array
     */
    protected function qf(string $q, array $qa = [], ?string $sk = null, ?string $sv = null) {
        $sql = $this->getEntityManager()->getConnection(); // we got an usual PDO object there
        $stmt = $sql->prepare($q);
        foreach($qa as $k => $v) {
            $stmt->bindValue($k, $v);
        }
        $stmt->execute();
        if(empty($sk) || empty($sv)) {
            $returns = $stmt->fetchAll(PDO::FETCH_ASSOC);
        } else {
            $returns = [];
            while($l = $stmt->fetch(PDO::FETCH_ASSOC)) {
                if(array_key_exists($sk, $l) && array_key_exists($sv, $l)) {
                    $returns[$l[$sk]] = $l[$sv];
                }
            }
        }
        return $returns;
    }
    
    /**
     * 
     * @param User $user
     * @param string $filter
     * @return [['skill' => Skill, 'val' => int]]
     */
    public function grabMergedSkillsForPlayer(User $user, string $filter = null): array {
        $returns = [];
        
        // first, general skills from main character
        $q = "select c.`skill_id` as id, c.`points` "
                . " from `characterskills` c "
                . (empty($filter)? "":" left join `skills` z on z.`id`=c.`skill_id` ")
                . " where c.`character_id`=:cid and coalesce(c.`points`,0)!=0 "
                . (empty($filter)? "":" and z.`attribute`=:flt");
        $qa = ['cid' => $user->getMainCharacter()->getId(),];
        if(!empty($filter)) { $qa['flt'] = $filter; }
        $character = $this->qf($q, $qa, 'id', 'points');
        
        // then, about global researches
        $q = "select s.`skill_id` as id, sum(coalesce(s.`points`, 0)) as points "
                . " from `technologies` t "
                . " left join `researchskills` s on s.`research_id`=t.`research_id` "
                . (empty($filter)? "":" left join `skills` z on z.`id`=s.`skill_id` ")
                . " where t.`player_id`=:pid and t.`date_found` is not null "
                . (empty($filter)? "":" and z.`attribute`=:flt ")
                . " group by s.`skill_id` having points!=0 ";
        $qa = ['pid' => $user->getId(),];
        if(!empty($filter)) { $qa['flt'] = $filter; }
        $techs = $this->qf($q, $qa, 'id', 'points');
        
        foreach($character as $sid => $svl) {
            $returns[$sid] = [
                'skill' => $this->find($sid),
                'val' => $svl,
            ];
        }
        
        foreach($techs as $sid => $svl) {
            if(!array_key_exists($sid, $returns)) {
                $returns[$sid] = [
                    'skill' => $this->find($sid),
                    'val' => 0,
                ];
            }
            $returns[$sid]['val'] += $svl;
        }
        
        return $returns;
    }
    
    /**
     * 
     * @param Colony $colony
     * @param bool $andPlayer
     * @param string $filter
     * @return [['skill' => Skill, 'val' => int]]
     */
    public function grabMergedSkillsForColony(Colony $colony, bool $andPlayer = true, string $filter = null): array {
        $returns = [];
        
        if($andPlayer) {
            $returns = $this->grabMergedSkillsForPlayer($colony->getOwner(), $filter);
        }
        
        // first, the colony's leader
        $leader = [];
        if(!empty($colony->getLeader())) {
            $q = "select c.`skill_id` as id, c.`points` "
                    . " from `characterskills` c "
                    . (empty($filter)? "":" left join `skills` z on z.`id`=c.`skill_id` ")
                    . " where c.`character_id`=:cid and coalesce(c.`points`,0)!=0"
                    . (empty($filter)? "":" and z.`attribute`=:flt");
            $qa = ['cid' => $colony->getLeader()->getId(),];
            if(!empty($filter)) { $qa['flt'] = $filter; }
            $leader = $this->qf($q, $qa, 'id', 'points');
        }
        
        // then, the colony's buildings (we have a colonyskill entity, but i doubt it would help ? @TODO maybe delete it)
        $q = "select s.`skill_id` as id, sum(coalesce(s.`points`, 0) * coalesce(b.`level`, 0)) as points "
                . " from `colonybuildings` b "
                . " left join `buildingskills` s on s.`building_id`=s.`building_id` "
                . (empty($filter)? "":" left join `skills` z on z.`id`=s.`skill_id` ")
                . " where b.`colony_id`=:cid and coalesce(b.`level`, 0)>0 "
                . (empty($filter)? "":" and z.`attribute`=:flt")
                . " group by s.`skill_id` having points!=0 ";
        $qa = ['cid' => $colony->getId(),];
        if(!empty($filter)) { $qa['flt'] = $filter; }
        $builds = $this->qf($q, $qa, 'id', 'points');
        
        // some special skills ? planets ? maybe @TODO
        foreach($builds as $sid => $svl) {
            if(!array_key_exists($sid, $returns)) {
                $returns[$sid] = [
                    'skill' => $this->find($sid),
                    'val' => 0,
                ];
            }
            $returns[$sid]['val'] += $svl;
        }
        
        foreach($leader as $sid => $svl) {
            if(!array_key_exists($sid, $returns)) {
                $returns[$sid] = [
                    'skill' => $this->find($sid),
                    'val' => 0,
                ];
            }
            $returns[$sid]['val'] += $svl;
        }
        
        return $returns;
    }
}

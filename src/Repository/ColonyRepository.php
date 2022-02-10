<?php
namespace App\Repository;

use App\Entity\Building;
use App\Entity\BuildQueue;
use App\Entity\Colony;
use App\Entity\ColonyBuilding;
use App\Entity\ColonyStock;
use App\Entity\Resource;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Exception;

/**
 * Description of ColonyRepository
 *
 * @author lpu8er
 */
class ColonyRepository extends ServiceEntityRepository {
    /**
     * 
     * @param ManagerRegistry $registry
     */
    public function __construct(ManagerRegistry $registry) {
        parent::__construct($registry, Colony::class);
    }
    
    /**
     * 
     * @param Colony $colony
     * @return ColonyStock[]
     */
    public function getPaddedResources(Colony $colony) {
        $returns = [];
        $allResources = $this->getEntityManager()->getRepository(Resource::class)->findAll();
        foreach($allResources as $res) {
            $cs = new ColonyStock;
            $cs->setColony($colony);
            $cs->setResource($res);
            $cs->setStocks(0.0);
            $returns[$res->getId()] = $cs;
        }
        $colonyStocks = $colony->getStocks();
        foreach($colonyStocks as $cs) {
            $returns[$cs->getResource()->getId()] = $cs;
        }
        return $returns;
    }
    
    /**
     * Get all buildable and built buildings.
     * @param Colony $colony
     * @return Building[]
     */
    public function getPaddedBuildings(Colony $colony) {
        $returns = [];
        // first of all, grab all technologies
    }
    
    /**
     * There is actually some "minimum maximum" depending on the colony
     * @param Colony $colony
     * @return float
     */
    public function getMaxStockSize(Colony $colony) {
        $returns = 0.0;
        if(in_array(Colony::CTYPE_EARTH === $colony->getCtype())) {
            
        }
        return $returns;
    }
    
    /**
     * There is actually some "minimum maximum" depending on the colony
     * This is mostly useless for earthly colonies
     * @param Colony $colony
     * @return float
     */
    public function getMaxStockMass(Colony $colony) {
        $returns = 0.0;
        if(in_array(Colony::CTYPE_EARTH === $colony->getCtype())) {
            
        }
        return $returns;
    }
    
    /**
     * Recompute the ColonySkill table for a colony
     * @param Colony $colony
     */
    public function recomputeSkills(Colony $colony) {
        $cskRepo = $this->_em->getRepository(\App\Entity\ColonySkill::class);
        // empty the colony skills for this colony
        $skills = $cskRepo->findByColony($colony->getId());
        foreach($skills as $sk) {
            $this->_em->remove($sk);
        }
        $this->_em->flush();
        // blah blah doctrine.
        // @TODO
    }
    
    /**
     * Recompute the ColonyExtraction table for a colony
     * @depends recomputeSkills()
     * @param Colony $colony
     * @param bool $useSkills @TODO that needs to break down that query into N query, one by resource
     */
    public function recomputeExtraction(Colony $colony, bool $useSkills = false) {
        $cexRepo = $this->_em->getRepository(\App\Entity\ColonyExtraction::class);
        // empty the colony extraction for this colony
        $extractors = $cexRepo->findByColony($colony->getId());
        foreach($extractors as $ex) {
            $this->_em->remove($ex);
        }
        $this->_em->flush();
        // because doctrine is a mess,
        // we need to find first enabled buildings before searching which ones are extractors
        // this is because if we add reverse link from buildings to colonybuildings
        // it'll load all colonybuildings when we load a building through doctrine query builder
        // So, just go through the native query.
        $q = "insert into `colonyextractions` (`colony_id`, `resource_id`, `nb`) "
                . " select :cid, be.`resource_id`, sum(floor(be.`nb` * (cb.`running` / 100))) "
                . " from `buildingextractions` be "
                . " left join `colonybuildings` cb on cb.`building_id`=be.`building_id` "
                . " left join `colonies` c on c.`id`=cb.`colony_id` "
                . ($useSkills? (" left join `skills` sk on sk.`attribute`=:ska and sk.`resource_id`=br.`resource_id` " // we'll use skills 
                . " left join `colonyskills` skb on skb.`colony_id`=c.`id` and skb.`skill_id`=sk.`id` " // buildings skills
                . " left join `characterskills` skc on skc.`character_id`=c.`leader_id` and skc.`skill_id`=sk.`id` " // leader skills
                . " left join `characterskills` skm on skm.`character_id`=:mid and skm.`skill_id`=sk.`id` " ):"")
                . " where c.`id`=:cid and cb.`running`>0 "
                . " group by be.`resource_id` ";
        $this->_em->getConnection()->executeUpdate($q, [
            'cid' => $colony->getId(),
            'ska' => \App\Entity\Skill::ATTRIBUTE_EXTRACT,
            'skm' => $colony->getOwner()->getMainCharacter()->getId(),
            ]);
    }
    
    /**
     * Recompute the ColonyProduction table for a colony
     * @param Colony $colony
     */
    public function recomputeProduction(Colony $colony) {
        
    }
    
    /**
     * Find and convert ending BuildQueue to Building then trigger the built event
     */
    public function convertAndTriggerBuilt() {
        $buildQueues = $this->_em->getRepository(BuildQueue::class)->findby([
            'points' => 0,
        ]);
        foreach($buildQueues as $bq) {
            $this->triggeredBuilt($bq);
        }
    }
    
    /**
     * Smart trigger, depending on building, for skills, extraction, production.
     * @param BuildQueue $bq
     * @return ColonyBuilding
     */
    public function triggeredBuilt(BuildQueue $bq, int $running = 100): ColonyBuilding {
        // give back the workers
        $colony = $bq->getColony();
        $colony->setWorkers($colony->getWorkers() - $bq->getWorkers());
        $cb = new ColonyBuilding();
        $cb->setBuilding($bq->getBuilding());
        $cb->setColony($bq->getColony());
        $cb->setLevel(1); // @TODO
        $cb->setRunning(false);
        $this->_em->persist($cb);
        $this->_em->persist($colony);
        $this->_em->remove($bq); // delete the buildqueue
        $this->_em->flush();
        // now, trigger the run if running > 0
        if($running) {
            $this->changeRunningBuilding($bq->getColony(), $bq->getBuilding(), $running);
        }
        return $cb;
    }
    
    /**
     * Reduce resource from stock.
     * Beware : it is controller duty to check if there is enough resource to reduce.
     * @param Colony $colony
     * @param Resource $res
     * @param int $quantity
     * @return bool
     */
    public function reduceStock(Colony $colony, Resource $res, int $quantity): bool {
        $returns = true;
        try {
            $stock = $this->_em->getRepository(ColonyStock::class)->findOneBy([
                'colony' => $colony->getId(),
                'resource' => $res->getId(),
            ]);
            $stock->setStocks($stock->getStocks() - $quantity);
            $this->_em->persist($stock);
            $this->_em->flush();
        } catch(Exception $e) {
            throw $e;
            $returns = false;
        }
        return $returns;
    }
    
    /**
     * Reduce workers from colony
     * @param Colony $colony
     * @param int $workers
     * @return bool
     * @throws Exception
     */
    public function useWorkers(Colony $colony, int $workers): bool {
        $returns = true;
        try {
            if($workers <= $colony->getAvailableWorkers()) {
                $colony->setWorkers($colony->getWorkers() + $workers);
                $this->_em->persist($colony);
                $this->_em->flush();
            } else {
                throw new Exception('Not enough workers !');
            }
        } catch(Exception $e) {
            throw $e;
            $returns = false;
        }
        return $returns;
    }
    
    /**
     * Change the running value for a building, recompte all extractions/productions/skills table depending on building
     * @param Colony $colony
     * @param Building $building
     * @param int $val
     * @return \self
     */
    public function changeRunningBuilding(Colony $colony, Building $building, int $val): self {
        $gotSkills = false;
        $gotExtractionSkills = false;
        $gotProductionSkills = false;
        $isExtractor = false;
        $isProductor = false;
        
        $colonyBuilding = $this->_em->getRepository(ColonyBuilding::class)->findOneBy([
            'colony' => $colony->getId(),
            'building' => $building->getId(),
        ]); /** @var ColonyBuilding $colonyBuilding */
        
        if(!empty($colonyBuilding)) {
            $bskRepo = $this->_em->getRepository(\App\Entity\BuildingSkill::class);
            $bexRepo = $this->_em->getRepository(\App\Entity\BuildingExtraction::class);
            $bprRepo = $this->_em->getRepository(\App\Entity\BuildingProduction::class);

            $bskList = $bskRepo->findByBuilding($building->getId());
            foreach($bskList as $bsk) { /** @var \App\Entity\BuildingSkill $bsk */
                $gotSkills = true;
                $gotExtractionSkills = $gotExtractionSkills || in_array($bsk->getSkill()->getAttribute(), [
                    \App\Entity\Skill::ATTRIBUTE_EXTRACT,
                ]);
                $gotProductionSkills = $gotProductionSkills || in_array($bsk->getSkill()->getAttribute(), [
                    \App\Entity\Skill::ATTRIBUTE_PRODSPEED,
                    \App\Entity\Skill::ATTRIBUTE_PRODUCTION,
                ]);
                if($gotExtractionSkills && $gotProductionSkills) { break; } // no need to do more
            }

            if(!$gotExtractionSkills) { // if we don't have extraction skills, check if we really need to recompute extractors
                $isExtractor = (0 < $bexRepo->count(['building' => $building->getId(),]));
            }

            if(!$gotProductionSkills) { // if we don't have extraction skills, check if we really need to recompute extractors
                $isProductor = (0 < $bprRepo->count(['building' => $building->getId(),]));
            }

            // apply the value (finally !)
            $colonyBuilding->setRunning($val);
            $this->_em->persist($colonyBuilding);
            $this->_em->flush();

            // in any case, we'll recompute skills if that building got any skill
            if($gotSkills) {
                $this->recomputeSkills($colony);
            }
            // then, depending on what we need
            if($isExtractor || $gotExtractionSkills) {
                $this->recomputeExtraction($colony);
            }
            if($isProductor || $gotProductionSkills) {
                $this->recomputeProduction($colony);
            }
        } // wtf ?
        return $this;
    }
    
    /**
     * 
     * @param Colony $colony
     * @return string[]
     */
    public function mergeSpecials(Colony $colony): array {
        if(null === $colony->getSpecials()) {
            $specials = [];
            foreach($colony->getBuildings() as $b) {
                $s = $b->getBuilding()->getSpecial();
                if(!empty($s)) {
                    $specials[$s] = $s;
                }
            }
            $colony->setSpecials($specials);
        }
        return $colony->getSpecials();
    }
    
    /**
     * 
     * @param Colony $colony
     * @return bool
     */
    public function hasSpaceport(Colony $colony): bool {
        return in_array(Building::SPECIAL_SPACEPORT, $this->mergeSpecials($colony));
    }
    
    /**
     * 
     * @param Colony $colony
     * @return bool
     */
    public function hasSpacefactory(Colony $colony): bool {
        return in_array(Building::SPECIAL_SPACEFACTORY, $this->mergeSpecials($colony));
    }
    
    /**
     * Clean up all empty colonystocks
     */
    public function cleanupAllStocks(): self {
        $q = "delete from `colonystocks` where `stocks`=0";
        $pdo = $this->_em->getConnection();
        $pdo->executeUpdate($q);
        return $this;
    }
}

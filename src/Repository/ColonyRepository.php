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
        
    }
    
    /**
     * Recompute the ColonyExtraction table for a colony
     * @param Colony $colony
     */
    public function recomputeExtraction(Colony $colony) {
        
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
    public function triggeredBuilt(BuildQueue $bq): ColonyBuilding {
        $cb = new ColonyBuilding();
        $cb->setBuilding($bq->getBuilding());
        $cb->setColony($bq->getColony());
        $cb->setLevel(1); // @TODO
        $cb->setRunning(false); // never running at first, maybe a parameter ?
        $this->_em->persist($cb);
        $this->_em->remove($bq); // delete the buildqueue
        $this->_em->flush();
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
}

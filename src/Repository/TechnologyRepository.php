<?php
namespace App\Repository;

use App\Entity\Technology;
use App\Entity\User;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Persistence\ManagerRegistry;

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
     * Retrieve all technologies that can be started (or not, depending on resources)
     * @param Colony $colony
     * @return Research[]
     */
    public function visibleList(Colony $colony, bool $checkResources = false): array {
        $returns = [];
        
        return $returns;
    }
}

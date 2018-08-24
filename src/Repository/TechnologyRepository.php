<?php
namespace App\Repository;

use App\Entity\Technology;
use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * Description of TechnologyRepository
 *
 * @author lpu8er
 */
class TechnologyRepository extends ServiceEntityRepository {
    /**
     * 
     * @param RegistryInterface $registry
     */
    public function __construct(RegistryInterface $registry) {
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
}

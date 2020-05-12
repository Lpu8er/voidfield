<?php
namespace App\Repository;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * Description of CharacterRepository
 *
 * @author lpu8er
 */
class CharacterRepository extends ServiceEntityRepository {
    /**
     * 
     * @param RegistryInterface $registry
     */
    public function __construct(ManagerRegistry $registry) {
        parent::__construct($registry, \App\Entity\Character::class);
    }
}

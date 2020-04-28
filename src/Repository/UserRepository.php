<?php
namespace App\Repository;

use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bridge\Doctrine\RegistryInterface;

class UserRepository extends ServiceEntityRepository {
    /**
     * 
     * @param RegistryInterface $registry
     */
    public function __construct(ManagerRegistry $registry) {
        parent::__construct($registry, User::class);
    }
    
    /**
     * Search if an user is already used by email and/or username
     * @param type $email
     * @param type $username
     * @return bool if some user was found
     */
    public function searchAnyEmailUsername(string $email, string $username): bool {
        $qb = $this->createQueryBuilder('u');
        $qb->where('u.email=:e')
           ->orWhere('u.username=:u')
           ->setParameter('e', $email)
           ->setParameter('u', $username);
        $r = $qb->getQuery()->getResult();
        return !empty($r);
    }
    
}

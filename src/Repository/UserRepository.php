<?php
namespace App\Repository;

use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bridge\Doctrine\RegistryInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

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
    
    /**
     * 
     * @param string $username
     * @param string $email
     * @param string $pwd
     * @param UserPasswordEncoderInterface $encoder
     * @param float $startMoney
     * @return User
     */
    public function createUser(string $username, string $email, string $pwd, UserPasswordEncoderInterface $encoder, float $startMoney = 0.00): User {
        $u = new User;
        $u->setAdmin(false);
        $u->setEmail($email);
        $u->setMoney($startMoney);
        $u->setPwd($encoder->encodePassword($u, $pwd));
        $u->setStatus(User::STATUS_ACTIVE);
        $u->setUsername($username);
        $this->getEntityManager()->persist($u);
        $this->getEntityManager()->flush();
        return $u;
    }
}

<?php
namespace App\Repository;

use App\Entity\Character;
use DateInterval;
use DateTime;
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
        parent::__construct($registry, Character::class);
    }
    
    /**
     * 
     * @param string $firstName
     * @param string $lastName
     * @param string $givenName
     * @param int $usedSkillPoints
     * @param int $age
     * @param int $gender
     * @param string $race
     * @return Character
     */
    public function generateMain(string $firstName, string $lastName, string $givenName, int $baseSkillPoints, int $usedSkillPoints = 0, int $age = null, int $gender = null, string $race = null): Character {
        $c = new Character;
        $c->setBirthDate((new DateTime)->sub(new DateInterval('P'.strval(max(10, $age)).'Y')));
        $c->setLvl(1);
        $c->setXp(0);
        $c->setHealth(100);
        $c->setStamina(100);
        $c->setIsMain(true);
        $c->setFirstName($firstName);
        $c->setLastName($lastName);
        $c->setGivenName($givenName);
        $c->setGender($gender);
        $c->setRace($race);
        $c->setBaseSkillPoints($baseSkillPoints);
        $c->setUsedSkillPoints($usedSkillPoints);
        $this->_em->persist($c);
        $this->_em->flush();
        return $c;
    }
}

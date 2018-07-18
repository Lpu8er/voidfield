<?php
namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Description of Character
 *
 * @author lpu8er
 * @ORM\Entity()
 * @ORM\Table(name="characters")
 */
class Character {
    const RACE_HUMAN = 'human'; // classic, can elvove and reproduce, some needs
    const RACE_BOT = 'bot'; // cannot evolve nor reproduce, less needs
    
    const GENDER_NONE = 0;
    const GENDER_M = 1;
    const GENDER_F = 2;
    
    /**
     * 
     * @var int
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;
    /**
     * 
     * @var string
     * @ORM\Column(type="string")
     */
    protected $firstName;
    /**
     * 
     * @var string
     * @ORM\Column(type="string")
     */
    protected $givenName;
    /**
     * 
     * @var string
     * @ORM\Column(type="string")
     */
    protected $lastName;
    /**
     *
     * @var int
     * @ORM\Column(type="integer") 
     */
    protected $baseSkillPoints = 0;
    /**
     *
     * @var int
     * @ORM\Column(type="integer")
     */
    protected $usedSkillPoints = 0;
    /**
     *
     * @var \DateTime
     * @ORM\Column(type="date") 
     */
    protected $birthDate;
    /**
     *
     * @var int
     * @ORM\Column(type="integer") 
     */
    protected $health = 100;
    /**
     *
     * @var int
     * @ORM\Column(type="integer")
     */
    protected $stamina = 100; // the more a character is used, the more its stamina is reduced, once stamina at 0, it's stuck to rest some time and health is reduced
    /**
     *
     * @var string
     * @ORM\Column(type="string")
     */
    protected $race;
    /**
     *
     * @var string
     * @ORM\Column(type="string") 
     */
    protected $gender;
    /**
     *
     * @var User 
     * @ORM\ManyToOne(targetEntity="User")
     * @ORM\JoinColumn(name="owner_id", referencedColumnName="id")
     */
    protected $owner; // owner user
    /**
     *
     * @var bool
     * @ORM\Column(type="boolean")
     */
    protected $isMain = false; // is main character from user
    /**
     *
     * @var int
     * @ORM\Column(type="bigint")
     */
    protected $xp = 0;
    /**
     * 
     * @var int
     * @ORM\Column(type="integer")
     */
    protected $lvl = 1;
    
    public function getId() {
        return $this->id;
    }

    public function getFirstName() {
        return $this->firstName;
    }

    public function getGivenName() {
        return $this->givenName;
    }

    public function getLastName() {
        return $this->lastName;
    }

    public function getBaseSkillPoints() {
        return $this->baseSkillPoints;
    }

    public function getUsedSkillPoints() {
        return $this->usedSkillPoints;
    }

    public function getBirthDate(): \DateTime {
        return $this->birthDate;
    }

    public function getHealth() {
        return $this->health;
    }

    public function getStamina() {
        return $this->stamina;
    }

    public function getRace() {
        return $this->race;
    }

    public function getGender() {
        return $this->gender;
    }

    public function getOwner(): User {
        return $this->owner;
    }

    public function getIsMain() {
        return $this->isMain;
    }

    public function getXp() {
        return $this->xp;
    }

    public function getLvl() {
        return $this->lvl;
    }

    public function setId($id) {
        $this->id = $id;
        return $this;
    }

    public function setFirstName($firstName) {
        $this->firstName = $firstName;
        return $this;
    }

    public function setGivenName($givenName) {
        $this->givenName = $givenName;
        return $this;
    }

    public function setLastName($lastName) {
        $this->lastName = $lastName;
        return $this;
    }

    public function setBaseSkillPoints($baseSkillPoints) {
        $this->baseSkillPoints = $baseSkillPoints;
        return $this;
    }

    public function setUsedSkillPoints($usedSkillPoints) {
        $this->usedSkillPoints = $usedSkillPoints;
        return $this;
    }

    public function setBirthDate(\DateTime $birthDate) {
        $this->birthDate = $birthDate;
        return $this;
    }

    public function setHealth($health) {
        $this->health = $health;
        return $this;
    }

    public function setStamina($stamina) {
        $this->stamina = $stamina;
        return $this;
    }

    public function setRace($race) {
        $this->race = $race;
        return $this;
    }

    public function setGender($gender) {
        $this->gender = $gender;
        return $this;
    }

    public function setOwner(User $owner) {
        $this->owner = $owner;
        return $this;
    }

    public function setIsMain($isMain) {
        $this->isMain = $isMain;
        return $this;
    }

    public function setXp($xp) {
        $this->xp = $xp;
        return $this;
    }

    public function setLvl($lvl) {
        $this->lvl = $lvl;
        return $this;
    }


}

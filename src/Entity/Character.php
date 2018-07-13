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
}

<?php
namespace App\Entity;

/**
 * Description of Character
 *
 * @author lpu8er
 */
class Character {
    const RACE_HUMAN = 'human'; // classic, can elvove and reproduce, some needs
    const RACE_BOT = 'bot'; // cannot evolve nor reproduce, less needs
    
    const GENDER_NONE = 0;
    const GENDER_M = 1;
    const GENDER_F = 2;
    
    protected $id;
    protected $firstName;
    protected $givenName;
    protected $lastName;
    protected $baseSkillPoints;
    protected $usedSkillPoints;
    protected $birthDate;
    protected $health;
    protected $stamina; // the more a character is used, the more its stamina is reduced, once stamina at 0, it's stuck to rest some time and health is reduced
    protected $race;
    protected $gender;
    protected $owner; // owner user
    protected $isMain; // is main character from user
    protected $dateStartPregnant;
    protected $dateEndPregnant;
}

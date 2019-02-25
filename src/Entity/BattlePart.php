<?php
namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Description of BattlePart
 *
 * @author lpu8er
 * @ORM\Entity()
 * @ORM\Table(name="battleparts")
 */
class BattlePart {
    /**
     *
     * @var Battle
     */
    protected $battle;
    
    /**
     *
     * @var Fleet
     */
    protected $fleet;
    
    /**
     *
     * Those parts, if present, will be attacked whatever happens
     * By default, present fleets won't be attacked unless in war/bad standing OR (attacked AND not in alliance)
     * @var Fleet[]
     */
    protected $hostiles;
    
    /**
     *
     * Those parts, if present, will NEVER be attacked whatever happens
     * By default, present fleets won't be attacked unless in war/bad standing OR (attacked AND not in alliance)
     * @var Fleet[]
     */
    protected $allies;
}

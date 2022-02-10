<?php
namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Description of BuildingCond
 *
 * @author lpu8er
 * @ORM\Entity()
 * @ORM\Table(name="buildingconds")
 */
class BuildingCond {
    /**
     *
     * @var Research 
     * @ORM\Id
     * @ORM\ManyToOne(targetEntity="Research")
     * @ORM\JoinColumn(name="need_id", referencedColumnName="id")
     */
    protected $need;
    /**
     *
     * @var Building 
     * @ORM\Id
     * @ORM\ManyToOne(targetEntity="Building")
     * @ORM\JoinColumn(name="target_id", referencedColumnName="id")
     */
    protected $target;
    
    public function getNeed(): Research {
        return $this->need;
    }

    public function getTarget(): Building {
        return $this->target;
    }

    public function setNeed(Research $need) {
        $this->need = $need;
        return $this;
    }

    public function setTarget(Building $target) {
        $this->target = $target;
        return $this;
    }


}

<?php
namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Description of HullCond
 *
 * @author lpu8er
 * @ORM\Entity()
 * @ORM\Table(name="hullconds")
 */
class HullCond {
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
     * @var Hull 
     * @ORM\Id
     * @ORM\ManyToOne(targetEntity="Hull")
     * @ORM\JoinColumn(name="target_id", referencedColumnName="id")
     */
    protected $target;
}

<?php
namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Description of ResearchCond
 *
 * @author lpu8er
 * @ORM\Entity()
 * @ORM\Table(name="researchconds")
 */
class ResearchCond {
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
     * @var Research 
     * @ORM\Id
     * @ORM\ManyToOne(targetEntity="Research")
     * @ORM\JoinColumn(name="target_id", referencedColumnName="id")
     */
    protected $target;
}

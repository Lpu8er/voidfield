<?php
namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Description of ModuleCond
 *
 * @author lpu8er
 * @ORM\Entity()
 * @ORM\Table(name="moduleconds")
 */
class ModuleCond {
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
     * @var Module 
     * @ORM\Id
     * @ORM\ManyToOne(targetEntity="Module")
     * @ORM\JoinColumn(name="target_id", referencedColumnName="id")
     */
    protected $target;
}

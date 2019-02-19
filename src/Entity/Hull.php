<?php
namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Description of Hull
 *
 * @author lpu8er
 * @ORM\Entity()
 * @ORM\Table(name="hulls")
 */
class Hull {
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
    protected $name;
    /**
     * 
     * @var float
     * @ORM\Column(type="decimal", precision=20, scale=5)
     */
    protected $mass;
    /**
     * 
     * @var float
     * @ORM\Column(type="decimal", precision=20, scale=5)
     */
    protected $size;
    /**
     *
     * @var int
     * @ORM\Column(type="integer")
     */
    protected $signature;
    /**
     *
     * @var int
     * @ORM\Column(type="integer")
     */
    protected $exteqpSlots;
    /**
     *
     * @var int
     * @ORM\Column(type="integer")
     */
    protected $extutilSlots;
    /**
     *
     * @var int
     * @ORM\Column(type="integer")
     */
    protected $engineSlots;
    /**
     *
     * @var int
     * @ORM\Column(type="integer")
     */
    protected $inteqpSlots;
    /**
     *
     * @var int
     * @ORM\Column(type="integer")
     */
    protected $intutilSlots;
    /**
     *
     * @var int
     * @ORM\Column(type="integer")
     */
    protected $propSlots;
    /**
     *
     * @var int
     * @ORM\Column(type="integer")
     */
    protected $hitpoints;
}

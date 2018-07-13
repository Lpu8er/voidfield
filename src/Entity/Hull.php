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
    protected $name;
    protected $mass;
    protected $size;
    protected $signature;
    protected $exteqpSlots;
    protected $extutilSlots;
    protected $engineSlots;
    protected $inteqpSlots;
    protected $intutilSlots;
    protected $propSlots;
}

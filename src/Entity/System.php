<?php
namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Description of System
 *
 * @author lpu8er
 * @ORM\Entity()
 * @ORM\Table(name="systems")
 */
class System {
    /**
     * 
     * @var int
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;
    protected $name;
    protected $galaxy;
    protected $centerX;
    protected $centerY;
    protected $centerZ;
    protected $sov;
}

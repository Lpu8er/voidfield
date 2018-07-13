<?php
namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Description of Galaxy
 *
 * @author lpu8er
 * @ORM\Entity()
 * @ORM\Table(name="galaxies")
 */
class Galaxy {
    /**
     * 
     * @var int
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;
    protected $name;
}

<?php
namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Description of Alliance
 *
 * @author lpu8er
 * @ORM\Entity()
 * @ORM\Table(name="alliances")
 */
class Alliance {
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
     */
    protected $name;
    protected $description;
    protected $ticker;
    protected $foundationDate;
    protected $founder;
    protected $leader;
}

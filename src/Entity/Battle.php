<?php
namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Description of Battle
 *
 * @author lpu8er
 * @ORM\Entity()
 * @ORM\Table(name="battles")
 */
class Battle {
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
     * @var BattlePart[]
     */
    protected $parts;
    /**
     *
     * @var \DateTime
     * @ORM\Column(type="datetime") 
     */
    protected $startDate;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getStartDate(): ?\DateTimeInterface
    {
        return $this->startDate;
    }

    public function setStartDate(\DateTimeInterface $startDate): self
    {
        $this->startDate = $startDate;

        return $this;
    }
}

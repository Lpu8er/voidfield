<?php
namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Description of Technology
 *
 * @author lpu8er
 * @ORM\Entity(repositoryClass="App\Repository\TechnologyRepository")
 * @ORM\Table(name="technologies")
 */
class Technology {
    /**
     *
     * @var Research 
     * @ORM\Id
     * @ORM\ManyToOne(targetEntity="Research")
     * @ORM\JoinColumn(name="research_id", referencedColumnName="id")
     */
    protected $research;
    /**
     *
     * @var User 
     * @ORM\Id
     * @ORM\ManyToOne(targetEntity="User")
     * @ORM\JoinColumn(name="player_id", referencedColumnName="id")
     */
    protected $player;
    /**
     *
     * @var \DateTime
     * @ORM\Column(type="datetime", nullable=true)
     */
    protected $dateFound;

    public function getDateFound(): ?\DateTimeInterface
    {
        return $this->dateFound;
    }

    public function setDateFound(?\DateTimeInterface $dateFound): self
    {
        $this->dateFound = $dateFound;

        return $this;
    }

    public function getResearch(): ?Research
    {
        return $this->research;
    }

    public function setResearch(?Research $research): self
    {
        $this->research = $research;

        return $this;
    }

    public function getPlayer(): ?User
    {
        return $this->player;
    }

    public function setPlayer(?User $player): self
    {
        $this->player = $player;

        return $this;
    } // @TODO add a second date "train" to allow mid time (replicate and train all colonies)
}

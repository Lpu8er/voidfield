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
     * @ORM\Column(type="string")
     */
    protected $name;
    /**
     * 
     * @var string
     * @ORM\Column(type="text")
     */
    protected $description;
    /**
     * 
     * @var string
     * @ORM\Column(type="string")
     */
    protected $ticker;
    /**
     *
     * @var \DateTime
     * @ORM\Column(type="datetime") 
     */
    protected $foundationDate;
    /**
     *
     * @var Character 
     * @ORM\ManyToOne(targetEntity="Character")
     * @ORM\JoinColumn(name="founder_id", referencedColumnName="id")
     */
    protected $founder;
    /**
     *
     * @var Character 
     * @ORM\ManyToOne(targetEntity="Character")
     * @ORM\JoinColumn(name="founder_id", referencedColumnName="id")
     */
    protected $leader;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getTicker(): ?string
    {
        return $this->ticker;
    }

    public function setTicker(string $ticker): self
    {
        $this->ticker = $ticker;

        return $this;
    }

    public function getFoundationDate(): ?\DateTimeInterface
    {
        return $this->foundationDate;
    }

    public function setFoundationDate(\DateTimeInterface $foundationDate): self
    {
        $this->foundationDate = $foundationDate;

        return $this;
    }

    public function getFounder(): ?Character
    {
        return $this->founder;
    }

    public function setFounder(?Character $founder): self
    {
        $this->founder = $founder;

        return $this;
    }

    public function getLeader(): ?Character
    {
        return $this->leader;
    }

    public function setLeader(?Character $leader): self
    {
        $this->leader = $leader;

        return $this;
    }
}

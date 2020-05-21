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
     * @return string[]
     */
    public static function listSlots(): array {
        return [
            Module::SLOT_INTERNAL_ENGINE,
            Module::SLOT_PROPULSION,
            Module::SLOT_EXTERNAL_EQUIPMENT,
            Module::SLOT_EXTERNAL_UTILITY,
            Module::SLOT_INTERNAL_EQUIPMENT,
            Module::SLOT_INTERNAL_UTILITY,
        ];
    }
    
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
     * @ORM\Column(type="integer", options={"default" : 0})
     */
    protected $exteqpSlots = 0;
    /**
     *
     * @var int
     * @ORM\Column(type="integer", options={"default" : 0})
     */
    protected $extutilSlots = 0;
    /**
     *
     * @var int
     * @ORM\Column(type="integer", options={"default" : 0})
     */
    protected $engineSlots = 0;
    /**
     *
     * @var int
     * @ORM\Column(type="integer", options={"default" : 0})
     */
    protected $inteqpSlots = 0;
    /**
     *
     * @var int
     * @ORM\Column(type="integer", options={"default" : 0})
     */
    protected $intutilSlots = 0;
    /**
     *
     * @var int
     * @ORM\Column(type="integer", options={"default" : 0})
     */
    protected $propSlots = 0;
    /**
     *
     * @var int
     * @ORM\Column(type="integer")
     */
    protected $hitpoints;

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

    public function getMass()
    {
        return $this->mass;
    }

    public function setMass($mass): self
    {
        $this->mass = $mass;

        return $this;
    }

    public function getSize()
    {
        return $this->size;
    }

    public function setSize($size): self
    {
        $this->size = $size;

        return $this;
    }

    public function getSignature(): ?int
    {
        return $this->signature;
    }

    public function setSignature(int $signature): self
    {
        $this->signature = $signature;

        return $this;
    }

    public function getExteqpSlots(): ?int
    {
        return $this->exteqpSlots;
    }

    public function setExteqpSlots(int $exteqpSlots): self
    {
        $this->exteqpSlots = $exteqpSlots;

        return $this;
    }

    public function getExtutilSlots(): ?int
    {
        return $this->extutilSlots;
    }

    public function setExtutilSlots(int $extutilSlots): self
    {
        $this->extutilSlots = $extutilSlots;

        return $this;
    }

    public function getEngineSlots(): ?int
    {
        return $this->engineSlots;
    }

    public function setEngineSlots(int $engineSlots): self
    {
        $this->engineSlots = $engineSlots;

        return $this;
    }

    public function getInteqpSlots(): ?int
    {
        return $this->inteqpSlots;
    }

    public function setInteqpSlots(int $inteqpSlots): self
    {
        $this->inteqpSlots = $inteqpSlots;

        return $this;
    }

    public function getIntutilSlots(): ?int
    {
        return $this->intutilSlots;
    }

    public function setIntutilSlots(int $intutilSlots): self
    {
        $this->intutilSlots = $intutilSlots;

        return $this;
    }

    public function getPropSlots(): ?int
    {
        return $this->propSlots;
    }

    public function setPropSlots(int $propSlots): self
    {
        $this->propSlots = $propSlots;

        return $this;
    }

    public function getHitpoints(): ?int
    {
        return $this->hitpoints;
    }

    public function setHitpoints(int $hitpoints): self
    {
        $this->hitpoints = $hitpoints;

        return $this;
    }
}

<?php
namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Description of ResearchCond
 *
 * @author lpu8er
 * @ORM\Entity()
 * @ORM\Table(name="researchconds")
 */
class ResearchCond {
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
     * @var Research 
     * @ORM\Id
     * @ORM\ManyToOne(targetEntity="Research")
     * @ORM\JoinColumn(name="target_id", referencedColumnName="id")
     */
    protected $target;

    public function getNeed(): ?Research
    {
        return $this->need;
    }

    public function setNeed(?Research $need): self
    {
        $this->need = $need;

        return $this;
    }

    public function getTarget(): ?Research
    {
        return $this->target;
    }

    public function setTarget(?Research $target): self
    {
        $this->target = $target;

        return $this;
    }
}

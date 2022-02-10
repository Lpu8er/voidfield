<?php
namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Description of DailyLog
 *
 * @author lpu8er
 * @ORM\Entity()
 * @ORM\Table(name="dailylogs")
 */
class DailyLog {
    /**
     *
     * @var int 
     * @ORM\Id
     * @ORM\Column(type="integer") 
     */
    protected $y;
    /**
     *
     * @var int 
     * @ORM\Id
     * @ORM\Column(type="integer") 
     */
    protected $m;
    /**
     *
     * @var int 
     * @ORM\Id
     * @ORM\Column(type="integer") 
     */
    protected $d;
    /**
     *
     * @var Colony 
     * @ORM\Id
     * @ORM\ManyToOne(targetEntity="Colony")
     * @ORM\JoinColumn(name="colony_id", referencedColumnName="id")
     */
    protected $colony;
    /**
     *
     * @var User 
     * @ORM\ManyToOne(targetEntity="User")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     */
    protected $player;
    /**
     *
     * @var \DateTime
     * @ORM\Column(type="datetime") 
     */
    protected $logDate;
    /**
     * 
     * @var float
     * @ORM\Column(type="decimal", precision=20, scale=5)
     */
    protected $dailyTax = 0.0;
    /**
     * Amount of flat incomes from taxes
     * @var int
     * @ORM\Column(type="bigint")
     */
    protected $income = 0;
    /**
     * Money before the daily report
     * @var int
     * @ORM\Column(type="bigint")
     */
    protected $moneyBefore = 0;
    /**
     * Money after the daily report
     * @var int
     * @ORM\Column(type="bigint")
     */
    protected $moneyAfter = 0;
    /**
     * Partisans and dailyTax have influence over this, on daily basis, can move pretty fast (max 10%)
     * Negative : will add insatisfaction (that percent of neutrals will lead to baddies)
     * Positive : will add satisfaction (that percent of neutrals will lead to goodies)
     * @var float
     * @ORM\Column(type="decimal", precision=20, scale=5)
     */
    protected $satisfactionModifier = 0.0;
    /**
     * Only modifier on long term basis got some influence on this, move slowly (max 1%)
     * Negative : will add insatisfaction (that percent of baddies will lead to hostiles)
     * Positive : will add satisfaction (that percent of goodies will lead to partisans)
     * @var float
     * @ORM\Column(type="decimal", precision=20, scale=5)
     */
    protected $satisfactionDeriv = 0.0;
    /**
     *
     * @var int
     * @ORM\Column(type="integer")
     */
    protected $populationBefore = 0;
    /**
     *
     * @var int
     * @ORM\Column(type="integer")
     */
    protected $hostilesBefore = 0;
    /**
     *
     * @var int
     * @ORM\Column(type="integer")
     */
    protected $baddiesBefore = 0;
    /**
     *
     * @var int
     * @ORM\Column(type="integer")
     */
    protected $goodiesBefore = 0;
    /**
     *
     * @var int
     * @ORM\Column(type="integer")
     */
    protected $partisansBefore = 0;
    /**
     *
     * @var int
     * @ORM\Column(type="integer")
     */
    protected $populationAfter = 0;
    /**
     *
     * @var int
     * @ORM\Column(type="integer")
     */
    protected $hostilesAfter = 0;
    /**
     *
     * @var int
     * @ORM\Column(type="integer")
     */
    protected $baddiesAfter = 0;
    /**
     *
     * @var int
     * @ORM\Column(type="integer")
     */
    protected $goodiesAfter = 0;
    /**
     *
     * @var int
     * @ORM\Column(type="integer")
     */
    protected $partisansAfter = 0;

    public function getY(): ?int
    {
        return $this->y;
    }

    public function getM(): ?int
    {
        return $this->m;
    }

    public function getD(): ?int
    {
        return $this->d;
    }

    public function getLogDate(): ?\DateTimeInterface
    {
        return $this->logDate;
    }

    public function setLogDate(\DateTimeInterface $logDate): self
    {
        $this->logDate = $logDate;

        return $this;
    }

    public function getDailyTax()
    {
        return $this->dailyTax;
    }

    public function setDailyTax($dailyTax): self
    {
        $this->dailyTax = $dailyTax;

        return $this;
    }

    public function getIncome(): ?int
    {
        return $this->income;
    }

    public function setIncome(int $income): self
    {
        $this->income = $income;

        return $this;
    }

    public function getMoneyBefore(): ?int
    {
        return $this->moneyBefore;
    }

    public function setMoneyBefore(int $moneyBefore): self
    {
        $this->moneyBefore = $moneyBefore;

        return $this;
    }

    public function getMoneyAfter(): ?int
    {
        return $this->moneyAfter;
    }

    public function setMoneyAfter(int $moneyAfter): self
    {
        $this->moneyAfter = $moneyAfter;

        return $this;
    }

    public function getSatisfactionModifier()
    {
        return $this->satisfactionModifier;
    }

    public function setSatisfactionModifier($satisfactionModifier): self
    {
        $this->satisfactionModifier = $satisfactionModifier;

        return $this;
    }

    public function getSatisfactionDeriv()
    {
        return $this->satisfactionDeriv;
    }

    public function setSatisfactionDeriv($satisfactionDeriv): self
    {
        $this->satisfactionDeriv = $satisfactionDeriv;

        return $this;
    }

    public function getPopulationBefore(): ?int
    {
        return $this->populationBefore;
    }

    public function setPopulationBefore(int $populationBefore): self
    {
        $this->populationBefore = $populationBefore;

        return $this;
    }

    public function getHostilesBefore(): ?int
    {
        return $this->hostilesBefore;
    }

    public function setHostilesBefore(int $hostilesBefore): self
    {
        $this->hostilesBefore = $hostilesBefore;

        return $this;
    }

    public function getBaddiesBefore(): ?int
    {
        return $this->baddiesBefore;
    }

    public function setBaddiesBefore(int $baddiesBefore): self
    {
        $this->baddiesBefore = $baddiesBefore;

        return $this;
    }

    public function getGoodiesBefore(): ?int
    {
        return $this->goodiesBefore;
    }

    public function setGoodiesBefore(int $goodiesBefore): self
    {
        $this->goodiesBefore = $goodiesBefore;

        return $this;
    }

    public function getPartisansBefore(): ?int
    {
        return $this->partisansBefore;
    }

    public function setPartisansBefore(int $partisansBefore): self
    {
        $this->partisansBefore = $partisansBefore;

        return $this;
    }

    public function getPopulationAfter(): ?int
    {
        return $this->populationAfter;
    }

    public function setPopulationAfter(int $populationAfter): self
    {
        $this->populationAfter = $populationAfter;

        return $this;
    }

    public function getHostilesAfter(): ?int
    {
        return $this->hostilesAfter;
    }

    public function setHostilesAfter(int $hostilesAfter): self
    {
        $this->hostilesAfter = $hostilesAfter;

        return $this;
    }

    public function getBaddiesAfter(): ?int
    {
        return $this->baddiesAfter;
    }

    public function setBaddiesAfter(int $baddiesAfter): self
    {
        $this->baddiesAfter = $baddiesAfter;

        return $this;
    }

    public function getGoodiesAfter(): ?int
    {
        return $this->goodiesAfter;
    }

    public function setGoodiesAfter(int $goodiesAfter): self
    {
        $this->goodiesAfter = $goodiesAfter;

        return $this;
    }

    public function getPartisansAfter(): ?int
    {
        return $this->partisansAfter;
    }

    public function setPartisansAfter(int $partisansAfter): self
    {
        $this->partisansAfter = $partisansAfter;

        return $this;
    }

    public function getColony(): ?Colony
    {
        return $this->colony;
    }

    public function setColony(?Colony $colony): self
    {
        $this->colony = $colony;

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
    }
}

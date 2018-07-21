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
}

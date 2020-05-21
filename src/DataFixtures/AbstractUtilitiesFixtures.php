<?php
namespace App\DataFixtures;

use DateInterval;
use DateTime;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

/**
 * Description of AbstractUtilitiesFixtures
 *
 * @author lpu8er
 */
abstract class AbstractUtilitiesFixtures extends Fixture {
    /**
     *
     * @var int[]
     */
    protected static $intervalsCache = [];
    
    /**
     * 
     * @param string $interval
     * @param bool $ignoreCache
     * @return int
     */
    protected static function getSecondsFromInterval(string $interval, bool $ignoreCache = false): int {
        if($ignoreCache || !array_key_exists($interval, static::$intervalsCache)) {
            $startingPoint = new DateTime('2020-05-01 02:00:00');
            $endingPoint = clone $startingPoint;
            $endingPoint->add(new DateInterval($interval));
            $returns = intval($endingPoint->getTimestamp() - $startingPoint->getTimestamp());
            if(!$ignoreCache) {
                static::$intervalsCache[$interval] = $returns;
            }
        } else {
            $returns = static::$intervalsCache[$interval];
        }
        return $returns;
    }
    
    /**
     *
     * @var UserPasswordEncoderInterface 
     */
    protected $encoder = null;
    
    public function __construct(UserPasswordEncoderInterface $encoder = null) {
        $this->encoder = $encoder;
    }
}

<?php
namespace App\DataFixtures;

use App\Entity\Building;
use App\Entity\BuildingCond;
use App\Entity\BuildingConsumption;
use App\Entity\BuildingExtraction;
use App\Entity\BuildingProduction;
use App\Entity\BuildingSkill;
use App\Entity\BuildRecipe;
use App\Entity\Galaxy;
use App\Entity\Planet;
use App\Entity\Research;
use App\Entity\ResearchCond;
use App\Entity\ResearchRecipe;
use App\Entity\ResearchSkill;
use App\Entity\Resource;
use App\Entity\Skill;
use App\Entity\Star;
use App\Entity\System;
use App\Entity\User;
use DateInterval;
use DateTime;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
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
    
    /**
     * 
     * @param ObjectManager $em
     * @param string $username
     * @param string $mail
     * @param string $pwd
     * @param string $status
     * @return User
     */
    protected function createUser($em, string $username, string $mail, string $pwd, string $status): User {
        $user = new User;
        $user->setUsername($username);
        $user->setEmail($mail);
        $user->setStatus($status);
        $encoded = $this->encoder->encodePassword($user, $pwd);
        $user->setPwd($encoded);
        $em->persist($user);
        $em->flush();
        return $user;
    }
    
    /**
     * 
     * @param ObjectManager $em
     * @param string $name
     * @param float $mass
     * @param float $size
     * @param float $nutritive
     * @return Resource
     */
    protected function createResource($em, string $name, float $mass, float $size, float $nutritive): Resource {
        $res = new Resource;
        $res->setName($name);
        $res->setMass($mass);
        $res->setSize($size);
        $res->setNutritive($nutritive);
        $res->setRestricted(Resource::RESTRICT_AIR | Resource::RESTRICT_WATER | Resource::RESTRICT_EARTH);
        $em->persist($res);
        $em->flush();
        return $res;
    }
    
    /**
     * 
     * @param ObjectManager $em
     * @param string $name
     * @return Galaxy
     */
    protected function createGalaxy($em, string $name): Galaxy {
        $g = new Galaxy();
        $g->setName($name);
        $em->persist($g);
        $em->flush();
        return $g;
    }
    
    /**
     * 
     * @param ObjectManager $em
     * @param string $name
     * @param int $x
     * @param int $y
     * @param int $z
     * @param Galaxy $galaxy
     * @return System
     */
    protected function createSystem($em, string $name, int $x, int $y, int $z, Galaxy $galaxy): System {
        $sys = new System();
        $sys->setName($name);
        $sys->setCenterX($x);
        $sys->setCenterY($y);
        $sys->setCenterZ($z);
        $sys->setGalaxy($galaxy);
        $em->persist($sys);
        $em->flush();
        return $sys;
    }
    
    /**
     * 
     * @param ObjectManager $em
     * @param Galaxy $galaxy
     * @param System $system
     * @param string $name
     * @param int $energyStrength
     * @return Star
     */
    protected function createStandardStar($em, Galaxy $galaxy, System $system, string $name, int $energyStrength): Star {
        $s = new Star;
        $s->setAirToxicity(0);
        $s->setEarthToxicity(0);
        $s->setWaterToxicity(0);
        $s->setWaterPercent(0);
        $s->setWaterViability(0);
        $s->setMedWindSpeed(1260000);
        $s->setDerivWindSpeed(1000000);
        $s->setDescription('');
        $s->setEllipticCenterDistance(0);
        $s->setEnergyStrength($energyStrength);
        $s->setEol(null);
        $s->setGalaxy($galaxy);
        $s->setGravity(28);
        $s->setMinTemp(3500);
        $s->setMaxTemp(6000);
        $s->setRadius(696000);
        $s->setRgb('250,225,75');
        $s->setSpin(7000000);
        $s->setSystem($system);
        $s->setName($name);
        $s->setX(0);
        $s->setY(0);
        $s->setZ(0);
        $em->persist($s);
        $em->flush();
        return $s;
    }
    
    /**
     * 
     * @TODO compute usableLandSurface depending on other shit
     * 
     * @param ObjectManager $em
     * @param Galaxy $galaxy
     * @param System $system
     * @param Star $star
     * @param string $name
     * @param float $earthToxicity
     * @param float $waterToxicity
     * @param float $airToxicity
     * @param float $waterPercent
     * @param float $waterViability
     * @param float $medWind
     * @param float $derivWind
     * @param float $dist
     * @param float $grav
     * @param float $tempMin
     * @param float $tempMax
     * @param float $radius
     * @param float $spin
     * @param array $resources
     * @return Planet
     */
    protected function createPlanet($em,
            Galaxy $galaxy,
            System $system,
            Star $star,
            string $name,
            float $earthToxicity,
            float $waterToxicity,
            float $airToxicity,
            float $waterPercent,
            float $waterViability,
            float $medWind,
            float $derivWind,
            float $dist,
            float $grav,
            float $tempMin,
            float $tempMax,
            float $radius,
            float $spin,
            array $resources = []): Planet {
        $p = new Planet;
        $p->setGalaxy($galaxy);
        $p->setSystem($system);
        $p->setCenteredOn($star);
        $p->setName($name);
        $p->setEarthToxicity($earthToxicity);
        $p->setWaterToxicity($waterToxicity);
        $p->setAirToxicity($airToxicity);
        $p->setWaterPercent($waterPercent);
        $p->setWaterViability($waterViability);
        $p->setMedWindSpeed($medWind);
        $p->setDerivWindSpeed($derivWind);
        $p->setEllipticCenterDistance($dist);
        $p->setGravity($grav);
        $p->setMinTemp($tempMin);
        $p->setMaxTemp($tempMax);
        $p->setRadius($radius);
        $p->setSpin($spin);
        // computed values
        // usable surfaces
        $totalSurface = 4 * pi() * ($radius ** 2);
        $waterSurface = round($totalSurface * $waterPercent / 100);
        $earthSurface = floor($totalSurface - ($waterSurface * mt_rand(1.009, 1.1)));
        $p->setUsableLandSurface($earthSurface);
        $p->setUsableWaterSurface($waterSurface);
        $p->setUsableAtmosphericSurface($totalSurface * 1.5); // @TODO
        // coords
        $ox = $star->getX();
        $oy = $star->getY();
        $oz = $star->getZ();
        $sx = ((mt_rand(0,1)? -1:1) * mt_rand(pow($dist, 1/5), pow($dist, 1/2)));
        $sy = ((mt_rand(0,1)? -1:1) * mt_rand(pow($dist, 1/5), pow($dist, 1/2)));
        $sz = ((mt_rand(0,1)? -1:1) * mt_rand(pow($dist, 1/5), pow($dist, 1/2)));
        $nx = $ox + $sx;
        $ny = $oy + $sy;
        $nz = $oz + $sz;
        // randomly move one of the 3 to adjust dist
        $wh = mt_rand(0,2);
        // $dist**2 = ($nx - $ox)**2 + ($ny - $oy)**2 + ($nz - $oz)**2
        if($wh >= 2) { // z
            $nz = sqrt($dist**2 - (($nx - $ox)**2 + ($ny - $oy)**2)) + $oz;
        } elseif($wh >= 1) { // y
            $ny = sqrt($dist**2 - (($nx - $ox)**2 + ($nz - $oz)**2)) + $oy;
        } else { // x
            $nx = sqrt($dist**2 - (($ny - $oy)**2 + ($nz - $oz)**2)) + $ox;
        }
        $p->setX($nx);
        $p->setY($ny);
        $p->setZ($nz);
        echo '=========================='.PHP_EOL;
        echo $name.PHP_EOL;
        echo 'Sun : '.$ox.','.$oy.','.$oz.PHP_EOL;
        echo 'Distance : '.$dist.PHP_EOL;
        echo 'Position finale : '.$nx.','.$ny.','.$nz.PHP_EOL;
        echo '=========================='.PHP_EOL;
        $em->persist($p);
        $em->flush();
        // generate resources
        
        
        return $p;
    }
    
    /**
     * 
     * @param ObjectManager $em
     * @param string $name
     * @param string $attribute
     * @param type $value
     * @param string $damageType
     * @param Resource $resource
     * @param bool $usableOnCharacter
     * @return Skill
     */
    protected function createSkill(ObjectManager $em, string $name, string $attribute, $value, string $damageType = null, Resource $resource = null, bool $usableOnCharacter = false): Skill {
        $s = new Skill();
        $s->setName($name);
        $s->setAttribute($attribute);
        $s->setValue($value);
        $s->setDamageType($damageType);
        $s->setResource($resource);
        $s->setUsableOnCharacter($usableOnCharacter);
        $em->persist($s);
        $em->flush();
        
        return $s;
    }
    
    /**
     * 
     * @param ObjectManager $em
     * @param string $name
     * @param string $duration
     * @param int $points
     * @param int $cost
     * @param array $recipe
     * @param array $skills
     * @param string $replacing
     * @param array $conditions
     * @return Research
     */
    protected function createResearch(ObjectManager $em, string $name, string $duration, int $points, int $cost, array $recipe = [], array $skills = [], string $replacing = null, array $conditions = []): Research {
        $r = new Research;
        $r->setName($name);
        $r->setBaseDuration($duration);
        $r->setPoints($points);
        $r->setSearchCost($cost);
        $r->setReplacing(empty($replacing)? null:$this->getReference($replacing));
        $em->persist($r);
        $em->flush();
        
        $needsSomeFlush = false;
        // skills first
        foreach($skills as $skillKey => $skillPoints) {
            $rs = new ResearchSkill;
            $rs->setResearch($r);
            $rs->setSkill($this->getReference($skillKey));
            $rs->setPoints($skillPoints);
            $em->persist($rs);
            $needsSomeFlush = true;
        }
        // recipe then
        foreach($recipe as $resKey => $resCount) {
            $rr = new ResearchRecipe;
            $rr->setResearch($r);
            $rr->setResource($this->getReference($resKey));
            $rr->setNb($resCount);
            $em->persist($rr);
            $needsSomeFlush = true;
        }
        // conditions last
        foreach($conditions as $neededResearch) {
            $rc = new ResearchCond;
            $rc->setTarget($r);
            $rc->setNeed($this->getReference($neededResearch));
            $em->persist($rc);
            $needsSomeFlush = true;
        }
        if($needsSomeFlush) {
            $em->flush();
        }
        
        return $r;
    }
    
    /**
     * 
     * @param ObjectManager $em
     * @param string $name
     * @param string $duration
     * @param int $points
     * @param string $description
     * @param int $size
     * @param string $restrictedTo
     * @param string $special
     * @param int $hitpoints
     * @param int $cost
     * @param int $workers
     * @param int $workersConsumption
     * @param int $workersStock
     * @param int $energyConsumption
     * @param int $energyProd
     * @param int $energyStock
     * @param array $conds
     * @param array $recipe
     * @param array $production
     * @param array $consumption
     * @param array $extraction
     * @param array $skills
     * @param string $assaultType
     * @param int $assaultValue
     * @param string $replacing
     * @return Building
     */
    protected function createBuilding(ObjectManager $em, string $name, string $duration, int $points, string $description,
            int $size, string $restrictedTo, string $special, int $hitpoints,
            int $cost, int $workers, int $workersConsumption, int $workersStock,
            int $energyConsumption, int $energyProd, int $energyStock,
            array $conds, array $recipe,
            array $production = [], array $consumption = [], array $extraction = [], array $skills = [],
            string $assaultType = null, int $assaultValue = 0, string $replacing = null): Building {
        $b = new Building;
        // not at first
        $b->setAirToxicity(0);
        $b->setEarthToxicity(0);
        $b->setWaterToxicity(0);
        
        $b->setAlwaysVisible(empty($replacing));
        $b->setAssaultType($assaultType);
        $b->setAssaultValue($assaultValue);
        $b->setBaseDuration($duration);
        $b->setBuildCost($cost);
        $b->setBuildWorkersNeeds($workers);
        $b->setDescription($description);
        
        $b->setEnergyConsumption($energyConsumption);
        $b->setEnergyProd($energyProd);
        $b->setEnergyStock($energyStock);
        $b->setHitpoints($hitpoints);
        $b->setName($name);
        $b->setPoints($points);
        $b->setReplacing($b);
        $b->setRestrictedTo($restrictedTo);
        $b->setSize($size);
        $b->setSpecial($special);
        
        $b->setWorkers($workersConsumption);
        $b->setWorkersStock($workersStock);
        
        $em->persist($b);
        $em->flush();
        
        $needsSomeFlush = false;
        foreach($recipe as $resKey => $nb) {
            $br = new BuildRecipe;
            $br->setBuilding($b);
            $br->setResource($this->getReference($resKey));
            $br->setNb($nb);
            $em->persist($br);
            $needsSomeFlush = true;
        }
        foreach($production as $resKey => $nb) {
            $bp = new BuildingProduction;
            $bp->setBuilding($b);
            $bp->setResource($this->getReference($resKey));
            $bp->setNb($nb);
            $em->persist($bp);
            $needsSomeFlush = true;
        }
        foreach($consumption as $resKey => $nb) {
            $bc = new BuildingConsumption;
            $bc->setBuilding($b);
            $bc->setResource($this->getReference($resKey));
            $bc->setNb($nb);
            $em->persist($bc);
            $needsSomeFlush = true;
        }
        foreach($extraction as $resKey => $nb) {
            $bx = new BuildingExtraction;
            $bx->setBuilding($b);
            $bx->setResource($this->getReference($resKey));
            $bx->setNb($nb);
            $em->persist($bx);
            $needsSomeFlush = true;
        }
        foreach($conds as $resKey => $nb) {
            $bk = new BuildingCond;
            $bk->setTarget($b);
            $bk->setNeed($this->getReference($resKey));
            $bk->setNb($nb);
            $em->persist($bk);
            $needsSomeFlush = true;
        }
        foreach($skills as $skillKey => $nb) {
            $bl = new BuildingSkill;
            $bl->setBuilding($b);
            $bl->setSkill($this->getReference($skillKey));
            $bl->setPoints($nb);
            $em->persist($bl);
            $needsSomeFlush = true;
        }
        if($needsSomeFlush) {
            $em->flush();
        }
        
        return $b;
    }
}

<?php
namespace App\DataFixtures;

use App\Entity\Galaxy;
use App\Entity\Planet;
use App\Entity\Resource;
use App\Entity\Star;
use App\Entity\System;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

/**
 * Description of AppFixtures
 *
 * @author lpu8er
 */
class AppFixtures extends Fixture {
    const AU = 149597870;
    
    /**
     *
     * @var UserPasswordEncoderInterface 
     */
    protected $encoder = null;
    
    public function __construct(UserPasswordEncoderInterface $encoder = null) {
        $this->encoder = $encoder;
    }
    
    public function load(ObjectManager $manager) {
        // tmp
        $this->createUser($manager, 'Admin', 'lpu8er@gmail.com', 'test', User::STATUS_ACTIVE);
        
        // generate resource
        $iron = $this->createResource($manager, 'Ferreux', 100.0, 100.0, 0.0);
        $this->setReference('res-iron', $iron);
        $hydro = $this->createResource($manager, 'Hydrocarbure', 1.0, 10.0, 0.0);
        $this->setReference('res-hydro', $hydro);
        $quartz = $this->createResource($manager, 'Quartz', 150.0, 5.0, 0.0);
        $this->setReference('res-quartz', $quartz);
        $titane = $this->createResource($manager, 'Titane', 100.0, 100.0, 0.0);
        $this->setReference('res-titane', $titane);
        $water = $this->createResource($manager, 'Eau potable', 1.0, 1.0, 0.4);
        $this->setReference('res-water', $water);
        $wheat = $this->createResource($manager, 'Féculents', 0.8, 1.5, 1.5);
        $this->setReference('res-wheat', $wheat);
        $legfruits = $this->createResource($manager, 'Fruits et légumes', 1.2, 1.2, 1.0);
        $this->setReference('res-legfruits', $legfruits);
        $gold = $this->createResource($manager, 'Précieux', 80.0, 110.0, 0.0);
        $this->setReference('res-gold', $gold);
        
        // generate galaxy / systems
        $g = $this->createGalaxy($manager, 'Andromeda');
        $this->setReference('galaxy-a', $g);
        
        // start system
        $startSystem = $this->createSystem($manager, 'Système solaire', 1000, 1000, 1000, $g);
        $this->setReference('system-start', $startSystem);
        
        // sun
        $sun = $this->createStandardStar($manager, $g, $startSystem, 'Soleil', 1000000);
        $this->setReference('star-sun', $sun);
        
        // planets
        $planets = [
            'mercury' => [
                'name' => 'Mercure',
                'grav' => 0.38,
                'dist' => 0.4,
                'spin' => 10892,
                'radius' => 2400,
                'waterPercent' => 20.0,
                'waterViability' => 10.0,
                'tempMin' => -200,
                'tempMax' => 500,
                'resources' => [
                    'iron' => ['stock' => 0.0, 'prod' => 0.0, 'replate' => 0.0,],
                    'hydro' => ['stock' => 0.0, 'prod' => 0.0, 'replate' => 0.0,],
                    'quartz' => ['stock' => 0.0, 'prod' => 0.0, 'replate' => 0.0,],
                    'titane' => ['stock' => 0.0, 'prod' => 0.0, 'replate' => 0.0,],
                    'water' => ['stock' => 0.0, 'prod' => 0.0, 'replate' => 0.0,],
                    'wheat' => ['stock' => 0.0, 'prod' => 0.0, 'replate' => 0.0,],
                    'legfruits' => ['stock' => 0.0, 'prod' => 0.0, 'replate' => 0.0,],
                    'gold' => ['stock' => 0.0, 'prod' => 0.0, 'replate' => 0.0,],
                ],
            ],
            'venus' => [
                'name' => 'Vénus',
                'grav' => 0.9,
                'dist' => 0.7,
                'spin' => 6.52,
                'radius' => 6051,
                'waterPercent' => 5.0,
                'waterViability' => 10.0,
                'tempMin' => 400,
                'tempMax' => 500,
            ],
            'earth' => [
                'name' => 'Terre',
                'grav' => 1.0,
                'dist' => 1.0,
                'spin' => 0.46,
                'radius' => 6371,
                'waterPercent' => 70.0,
                'waterViability' => 99.9,
                'tempMin' => -90,
                'tempMax' => 60.0,
                'medWind' => 80,
                'derivWind' => 80,
            ],
            'mars' => [
                'name' => 'Mars',
                'grav' => 0.4,
                'dist' => 1.4,
                'spin' => 868,
                'radius' => 3390,
                'waterPercent' => 0.0,
                'waterViability' => 0.0,
                'tempMin' => -140,
                'tempMax' => 35,
            ],
            'jupiter' => [
                'name' => 'Jupiter',
                'grav' => 2.5,
                'dist' => 5.2,
                'spin' => 45000,
                'radius' => 70,
                'waterPercent' => 2.0,
                'waterViability' => 20.0,
                'tempMin' => -160,
                'tempMax' => -60,
            ],
            'saturn' => [
                'name' => 'Saturne',
                'grav' => 1.06,
                'dist' => 9.5,
                'spin' => 35500,
                'radius' => 58000,
                'waterPercent' => 5.0,
                'waterViability' => 2.0,
                'tempMin' => -190,
                'tempMax' => -90,
            ],
            'uranus' => [
                'name' => 'Uranus',
                'grav' => 0.89,
                'dist' => 20,
                'spin' => 9320,
                'radius' => 25000,
                'waterPercent' => 5.0,
                'waterViability' => 2.0,
                'tempMin' => -220,
                'tempMax' => -190,
            ],
            'neptune' => [
                'name' => 'Neptune',
                'grav' => 1.14,
                'dist' => 30,
                'spin' => 9650,
                'radius' => 24600,
                'waterPercent' => 95.0,
                'waterViability' => 5.0,
                'tempMin' => -210,
                'tempMax' => -180,
            ],
        ];
        foreach($planets as $kp => $pd) {
            $planet = $this->createPlanet($manager,
                    $g,
                    $startSystem,
                    $sun,
                    $pd['name'],
                    array_key_exists('earthToxicity', $pd)? $pd['earthToxicity']:0,
                    array_key_exists('waterToxicity', $pd)? $pd['waterToxicity']:0,
                    array_key_exists('airToxicity', $pd)? $pd['airToxicity']:0,
                    array_key_exists('waterPercent', $pd)? $pd['waterPercent']:0,
                    array_key_exists('waterViability', $pd)? $pd['waterViability']:0,
                    array_key_exists('medWind', $pd)? $pd['medWind']:0,
                    array_key_exists('derivWind', $pd)? $pd['derivWind']:0,
                    static::AU * (array_key_exists('dist', $pd)? $pd['dist']:0),
                    array_key_exists('grav', $pd)? $pd['grav']:0,
                    array_key_exists('tempMin', $pd)? $pd['tempMin']:0,
                    array_key_exists('tempMax', $pd)? $pd['tempMax']:0,
                    array_key_exists('radius', $pd)? $pd['radius']:0,
                    array_key_exists('spin', $pd)? $pd['spin']:0);
            $this->setReference('planet-'.$kp, $planet);
        }
        
        
        
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
    protected function createUser($em, $username, $mail, $pwd, $status) {
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
    protected function createResource($em, $name, $mass, $size, $nutritive) {
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
    protected function createGalaxy($em, $name) {
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
    protected function createSystem($em, $name, $x, $y, $z, $galaxy) {
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
    protected function createStandardStar($em, $galaxy, $system, $name, $energyStrength) {
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
            $galaxy,
            $system,
            $star,
            $name,
            $earthToxicity,
            $waterToxicity,
            $airToxicity,
            $waterPercent,
            $waterViability,
            $medWind,
            $derivWind,
            $dist,
            $grav,
            $tempMin,
            $tempMax,
            $radius,
            $spin,
            $resources = []) {
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
     * @return \App\Entity\Skill
     */
    protected function createSkill(ObjectManager $em, string $name, string $attribute, $value, string $damageType = null, Resource $resource = null, bool $usableOnCharacter = false) {
        $s = new \App\Entity\Skill();
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
     * @return \App\Entity\Research
     */
    protected function createResearch(ObjectManager $em, string $name, string $duration, int $points, int $cost, array $recipe = [], array $skills = [], string $replacing = null, array $conditions = []) {
        $r = new \App\Entity\Research;
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
            $rs = new \App\Entity\ResearchSkill;
            $rs->setResearch($r);
            $rs->setSkill($this->getReference($skillKey));
            $rs->setPoints($skillPoints);
            $em->persist($rs);
            $needsSomeFlush = true;
        }
        // recipe then
        foreach($recipe as $resKey => $resCount) {
            $rr = new \App\Entity\ResearchRecipe;
            $rr->setResearch($r);
            $rr->setResource($this->getReference($resKey));
            $rr->setNb($resCount);
            $em->persist($rr);
            $needsSomeFlush = true;
        }
        // conditions last
        foreach($conditions as $neededResearch) {
            $rc = new \App\Entity\ResearchCond;
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
    
    protected function createBuilding(ObjectManager $em, string $name, string $duration, int $points, string $description,
            int $size, string $restrictedTo, string $special, int $hitpoints,
            int $cost, int $workers, int $workersConsumption, int $workersStock,
            int $energyConsumption, int $energyProd, int $energyStock,
            array $conds, array $recipe,
            array $production = [], array $consumption = [], array $extraction = [], array $skills = [],
            string $assaultType = null, int $assaultValue = 0, string $replacing = null) {
        $b = new \App\Entity\Building;
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
            $br = new \App\Entity\BuildRecipe;
            $br->setBuilding($b);
            $br->setResource($this->getReference($resKey));
            $br->setNb($nb);
            $em->persist($br);
            $needsSomeFlush = true;
        }
        foreach($production as $resKey => $nb) {
            $bp = new \App\Entity\BuildingProduction;
            $bp->setBuilding($b);
            $bp->setResource($this->getReference($resKey));
            $bp->setNb($nb);
            $em->persist($bp);
            $needsSomeFlush = true;
        }
        foreach($consumption as $resKey => $nb) {
            $bc = new \App\Entity\BuildingConsumption;
            $bc->setBuilding($b);
            $bc->setResource($this->getReference($resKey));
            $bc->setNb($nb);
            $em->persist($bc);
            $needsSomeFlush = true;
        }
        foreach($extraction as $resKey => $nb) {
            $bx = new \App\Entity\BuildingExtraction;
            $bx->setBuilding($b);
            $bx->setResource($this->getReference($resKey));
            $bx->setNb($nb);
            $em->persist($bx);
            $needsSomeFlush = true;
        }
        foreach($conds as $resKey => $nb) {
            $bk = new \App\Entity\BuildingCond;
            $bk->setTarget($b);
            $bk->setNeed($this->getReference($resKey));
            $bk->setNb($nb);
            $em->persist($bk);
            $needsSomeFlush = true;
        }
        foreach($skills as $skillKey => $nb) {
            $bl = new \App\Entity\BuildingSkill;
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

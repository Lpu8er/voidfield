<?php
namespace App\DataFixtures;

use App\Entity\Resource;
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
    /**
     *
     * @var UserPasswordEncoderInterface 
     */
    protected $encoder = null;
    
    public function __construct(UserPasswordEncoderInterface $encoder = null) {
        $this->encoder = $encoder;
    }
    
    public function load(ObjectManager $manager) {
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
            'mercury' => [],
            'venus' => [],
            'earth' => [],
            'mars' => [],
            'jupiter' => [],
            'saturn' => [],
            'uranus' => [],
            'neptune' => [],
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
                    array_key_exists('dist', $pd)? $pd['dist']:0,
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
     * @return \App\Entity\Galaxy
     */
    protected function createGalaxy($em, $name) {
        $g = new \App\Entity\Galaxy();
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
     * @param \App\Entity\Galaxy $galaxy
     * @return \App\Entity\System
     */
    protected function createSystem($em, $name, $x, $y, $z, $galaxy) {
        $sys = new \App\Entity\System();
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
     * @param \App\Entity\Galaxy $galaxy
     * @param \App\Entity\System $system
     * @param string $name
     * @param int $energyStrength
     * @return \App\Entity\Star
     */
    protected function createStandardStar($em, $galaxy, $system, $name, $energyStrength) {
        $s = new \App\Entity\Star;
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
        $s->setGravity(30);
        $s->setMinTemp(3500);
        $s->setMaxTemp(6000);
        $s->setRadius(696000);
        $s->setRgb('250,225,75');
        $s->setSpin(7000000);
        $s->setSystem($system);
        $s->setName($name);
        $em->persist($s);
        $em->flush();
        return $s;
    }
    
    /**
     * 
     * @TODO compute usableLandSurface depending on other shit
     * 
     * @param ObjectManager $em
     * @param \App\Entity\Galaxy $galaxy
     * @param \App\Entity\System $system
     * @param \App\Entity\Star $star
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
     * @return \App\Entity\Planet
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
            $spin) {
        $p = new \App\Entity\Planet;
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
        $em->persist($p);
        $em->flush();
        return $p;
    }
}

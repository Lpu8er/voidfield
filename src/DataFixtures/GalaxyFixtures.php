<?php
namespace App\DataFixtures;

use App\Entity\Celestial;
use App\Entity\Galaxy;
use App\Entity\Planet;
use App\Entity\Star;
use App\Entity\System;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

/**
 * Description of GalaxyFixtures
 *
 * @author lpu8er
 */
class GalaxyFixtures extends AbstractUtilitiesFixtures implements DependentFixtureInterface {
    public function load(ObjectManager $manager) {
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
                    'iron' => ['stock' => pow(10, 10), 'prod' => 0.0, 'replate' => 0.0,],
                    'hydro' => ['stock' => pow(10, 10), 'prod' => 0.0, 'replate' => 0.0,],
                    'quartz' => ['stock' => pow(10, 10), 'prod' => 0.0, 'replate' => 0.0,],
                    'titane' => ['stock' => pow(10, 10), 'prod' => 0.0, 'replate' => 0.0,],
                    'water' => ['stock' => pow(10, 10), 'prod' => 0.0, 'replate' => 0.0,],
                    'wheat' => ['stock' => 0.0, 'prod' => 0.0, 'replate' => 0.0,],
                    'legfruits' => ['stock' => 0.0, 'prod' => 0.0, 'replate' => 0.0,],
                    'gold' => ['stock' => pow(10, 10), 'prod' => 0.0, 'replate' => 0.0,],
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
                'start' => true,
                'resources' => [
                    'iron' => ['stock' => pow(10, 10), 'prod' => 0.0, 'replate' => 0.0,],
                    'hydro' => ['stock' => pow(10, 10), 'prod' => 0.0, 'replate' => 0.0,],
                    'quartz' => ['stock' => pow(10, 10), 'prod' => 0.0, 'replate' => 0.0,],
                    'titane' => ['stock' => pow(10, 10), 'prod' => 0.0, 'replate' => 0.0,],
                    'water' => ['stock' => pow(10, 10), 'prod' => 0.0, 'replate' => 0.0,],
                    'wheat' => ['stock' => pow(10, 10), 'prod' => 0.0, 'replate' => 0.0,],
                    'legfruits' => ['stock' => pow(10, 10), 'prod' => 0.0, 'replate' => 0.0,],
                    'gold' => ['stock' => pow(10, 10), 'prod' => 0.0, 'replate' => 0.0,],
                ],
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
                    Celestial::AU * (array_key_exists('dist', $pd)? $pd['dist']:0),
                    array_key_exists('grav', $pd)? $pd['grav']:0,
                    array_key_exists('tempMin', $pd)? $pd['tempMin']:0,
                    array_key_exists('tempMax', $pd)? $pd['tempMax']:0,
                    array_key_exists('radius', $pd)? $pd['radius']:0,
                    array_key_exists('spin', $pd)? $pd['spin']:0,
                    array_key_exists('resources', $pd)? $pd['resources']:[],
                    !empty($pd['start']));
            $this->setReference('planet-'.$kp, $planet);
        }
    }
    
    public function getDependencies() {
        return [
            AppFixtures::class,
            ResourcesFixtures::class,
        ];
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
     * @param bool $startable
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
            array $resources = [],
            bool $startable = false): Planet {
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
        $p->setStartable($startable);
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
}

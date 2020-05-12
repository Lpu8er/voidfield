<?php
namespace App\DataFixtures;

use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

/**
 * Description of GalaxyFixtures
 *
 * @author lpu8er
 */
class GalaxyFixtures extends AbstractUtilitiesFixtures implements DependentFixtureInterface {
    const AU = 149597870;
    
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
    
    public function getDependencies() {
        return [
            AppFixtures::class,
            ResourcesFixtures::class,
        ];
    }
}

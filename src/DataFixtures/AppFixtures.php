<?php
namespace App\DataFixtures;

use App\Entity\Module;
use App\Entity\Skill;
use App\Entity\User;
use Doctrine\Common\Persistence\ObjectManager;

/**
 * Description of AppFixtures
 *
 * @author lpu8er
 */
class AppFixtures extends AbstractUtilitiesFixtures {
    const AU = 149597870;
    
    public function load(ObjectManager $manager) {
        // add initial bot to assert domination
        $this->createUser($manager, 'Lain', 'lpu8er+voidfield@gmail.com', md5(uniqid()), User::STATUS_BOT);
        
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
        
        $skills = [
            'attack-thermic' => [
                'name' => 'Expertise en attaque thermique',
                'attr' => Skill::ATTRIBUTE_ATTACK,
                'val' => 1.01, // *1.01 = +1%
                'dtype' => Module::DAMAGETYPE_THERMAL,
                'res' => null,
                'uc' => true,
            ],
            'attack-kinetic' => [
                'name' => 'Expertise en attaque cinétique',
                'attr' => Skill::ATTRIBUTE_ATTACK,
                'val' => 1.01, // *1.01 = +1%
                'dtype' => Module::DAMAGETYPE_KINETIC,
                'res' => null,
                'uc' => true,
            ],
            'attack-emp' => [
                'name' => 'Expertise en attaque électromagnétique',
                'attr' => Skill::ATTRIBUTE_ATTACK,
                'val' => 1.01, // *1.01 = +1%
                'dtype' => Module::DAMAGETYPE_EMP,
                'res' => null,
                'uc' => true,
            ],
            'attack-explosive' => [
                'name' => 'Expertise en attaque explosive',
                'attr' => Skill::ATTRIBUTE_ATTACK,
                'val' => 1.01, // *1.01 = +1%
                'dtype' => Module::DAMAGETYPE_EXPLOSIVE,
                'res' => null,
                'uc' => true,
            ],
            'attack-corrosive' => [
                'name' => 'Expertise en attaque corrosive',
                'attr' => Skill::ATTRIBUTE_ATTACK,
                'val' => 1.01, // *1.01 = +1%
                'dtype' => Module::DAMAGETYPE_CORROSIVE,
                'res' => null,
                'uc' => true,
            ],
            'defense-kinetic' => [
                'name' => 'Expertise en coques',
                'attr' => Skill::ATTRIBUTE_DEFENSE,
                'val' => 1.01, // *1.01 = +1%
                'dtype' => Module::DAMAGETYPE_KINETIC,
                'res' => null,
                'uc' => true,
            ],
            'defense-thermal' => [
                'name' => 'Expertise anti-thermal',
                'attr' => Skill::ATTRIBUTE_DEFENSE,
                'val' => 1.01, // *1.01 = +1%
                'dtype' => Module::DAMAGETYPE_THERMAL,
                'res' => null,
                'uc' => true,
            ],
            'defense-corrosive' => [
                'name' => 'Expertise anti-corrosion',
                'attr' => Skill::ATTRIBUTE_DEFENSE,
                'val' => 1.01, // *1.01 = +1%
                'dtype' => Module::DAMAGETYPE_CORROSIVE,
                'res' => null,
                'uc' => true,
            ],
            'defense-exposive' => [
                'name' => 'Expertise anti-souffle',
                'attr' => Skill::ATTRIBUTE_DEFENSE,
                'val' => 1.01, // *1.01 = +1%
                'dtype' => Module::DAMAGETYPE_EXPLOSIVE,
                'res' => null,
                'uc' => true,
            ],
            'defense-emp' => [
                'name' => 'Expertise anti-EMP',
                'attr' => Skill::ATTRIBUTE_DEFENSE,
                'val' => 1.01, // *1.01 = +1%
                'dtype' => Module::DAMAGETYPE_EMP,
                'res' => null,
                'uc' => true,
            ],
            'speed' => [
                'name' => 'Accélération',
                'attr' => Skill::ATTRIBUTE_SPEED,
                'val' => 1.01, // *1.01 = +1%
                'dtype' => null,
                'res' => null,
                'uc' => true,
            ],
            'morale' => [
                'name' => 'Diplomatie',
                'attr' => Skill::ATTRIBUTE_MORALE,
                'val' => 1.01, // *1.01 = +1%
                'dtype' => null,
                'res' => null,
                'uc' => true,
            ],
            'zoology' => [
                'name' => 'Zoologie',
                'attr' => Skill::ATTRIBUTE_ZOOLOGY,
                'val' => 1.01, // *1.01 = +1%
                'dtype' => null,
                'res' => null,
                'uc' => true,
            ],
            'energy-prod' => [
                'name' => 'Expertise Tesla',
                'attr' => Skill::ATTRIBUTE_ENERGYPROD,
                'val' => 1.01, // *1.01 = +1%
                'dtype' => null,
                'res' => null,
                'uc' => true,
            ],
            'energy-conso' => [
                'name' => 'Economie d\'énergie',
                'attr' => Skill::ATTRIBUTE_ENERGYCONSUMPTION,
                'val' => 1.01, // *1.01 = +1%
                'dtype' => null,
                'res' => null,
                'uc' => true,
            ],
            'energy-stock' => [
                'name' => 'Expertise en condensats',
                'attr' => Skill::ATTRIBUTE_ENERGYSTOCK,
                'val' => 1.01, // *1.01 = +1%
                'dtype' => null,
                'res' => null,
                'uc' => true,
            ],
            'daily-cost' => [
                'name' => 'Economie',
                'attr' => Skill::ATTRIBUTE_DAILYCOST,
                'val' => 1.01, // *1.01 = +1%
                'dtype' => null,
                'res' => null,
                'uc' => true,
            ],
            'daily-income' => [
                'name' => 'Bourse',
                'attr' => Skill::ATTRIBUTE_DAILYINCOME,
                'val' => 1.01, // *1.01 = +1%
                'dtype' => null,
                'res' => null,
                'uc' => true,
            ],
            'research-speed' => [
                'name' => 'Scientifique',
                'attr' => Skill::ATTRIBUTE_RESEARCHSPEED,
                'val' => 1.01, // *1.01 = +1%
                'dtype' => null,
                'res' => null,
                'uc' => true,
            ],
            'stock-size' => [
                'name' => 'Expertise Tetris',
                'attr' => Skill::ATTRIBUTE_STOCKSIZE,
                'val' => 1.01, // *1.01 = +1%
                'dtype' => null,
                'res' => null,
                'uc' => true,
            ],
            'stock-mass' => [
                'name' => 'Connaissance des masses',
                'attr' => Skill::ATTRIBUTE_STOCKMASS,
                'val' => 1.01, // *1.01 = +1%
                'dtype' => null,
                'res' => null,
                'uc' => true,
            ],
            'scan' => [
                'name' => 'Scanner',
                'attr' => Skill::ATTRIBUTE_SCANSTRENGTH,
                'val' => 1.01, // *1.01 = +1%
                'dtype' => null,
                'res' => null,
                'uc' => true,
            ],
            'workers-stock' => [
                'name' => 'Expertise HLM',
                'attr' => Skill::ATTRIBUTE_WORKERSSTOCK,
                'val' => 1.01, // *1.01 = +1%
                'dtype' => null,
                'res' => null,
                'uc' => true,
            ],
            'workers-prod' => [
                'name' => 'Expert en natalité',
                'attr' => Skill::ATTRIBUTE_WORKERSPROD,
                'val' => 1.01, // *1.01 = +1%
                'dtype' => null,
                'res' => null,
                'uc' => true,
            ],
            'workers-conso' => [
                'name' => 'Exploitation humaine',
                'attr' => Skill::ATTRIBUTE_WORKERSCONSUMPTION,
                'val' => 1.01, // *1.01 = +1%
                'dtype' => null,
                'res' => null,
                'uc' => true,
            ],
            'build-cost' => [
                'name' => 'Economie des coûts de construction',
                'attr' => Skill::ATTRIBUTE_BUILDCOST,
                'val' => 1.01, // *1.01 = +1%
                'dtype' => null,
                'res' => null,
                'uc' => true,
            ],
            'extract-iron' => [
                'name' => 'Expertise en métaux',
                'attr' => Skill::ATTRIBUTE_EXTRACT,
                'val' => 1.02, // *1.01 = +1%
                'dtype' => null,
                'res' => 'iron',
                'uc' => true,
            ],
            'extract-hydro' => [
                'name' => 'Expertise en hydrocarbures',
                'attr' => Skill::ATTRIBUTE_EXTRACT,
                'val' => 1.02, // *1.01 = +1%
                'dtype' => null,
                'res' => 'hydro',
                'uc' => true,
            ],
            'extract-quartz' => [
                'name' => 'Expertise en cristaux',
                'attr' => Skill::ATTRIBUTE_EXTRACT,
                'val' => 1.02, // *1.01 = +1%
                'dtype' => null,
                'res' => 'quartz',
                'uc' => true,
            ],
            'extract-titane' => [
                'name' => 'Expertise en métaux lourds',
                'attr' => Skill::ATTRIBUTE_EXTRACT,
                'val' => 1.02, // *1.01 = +1%
                'dtype' => null,
                'res' => 'titane',
                'uc' => true,
            ],
            'extract-water' => [
                'name' => 'Expertise aquatique',
                'attr' => Skill::ATTRIBUTE_EXTRACT,
                'val' => 1.02, // *1.01 = +1%
                'dtype' => null,
                'res' => 'water',
                'uc' => true,
            ],
            'extract-gold' => [
                'name' => 'Expertise en métaux précieux',
                'attr' => Skill::ATTRIBUTE_EXTRACT,
                'val' => 1.02, // *1.01 = +1%
                'dtype' => null,
                'res' => 'gold',
                'uc' => true,
            ],
            'prod-water' => [
                'name' => 'Purificateur',
                'attr' => Skill::ATTRIBUTE_PRODUCTION,
                'val' => 1.02,
                'dtype' => null,
                'res' => 'water',
                'uc' => true,
            ],
        ];
        foreach($skills as $sn => $skill) {
            $this->setReference('skill-'.$sn,
                    $this->createSkill($manager, $skill['name'], $skill['attr'], $skill['val'], $skill['dtype'], $skill['res'], $skill['uc']));
        }
        
        $researches = [
            'attack-explosive' => [
                'name'=> 'Assaut explosif',
                'duration' => 'PT1H',
                'points' => 60*60, // 1h
                'cost' => 1000,
                'recipe' => [
                    'res-iron' => 100,
                    'res-hydro' => 50,
                    'res-quartz' => 5,
                ],
                'skills' => [
                    'skill-attack-explosive' => 2, // +2 * 1.01
                ],
                'replacing' => null,
                'conditions' => [],
            ],
        ];
        foreach($researches as $rn => $research) {
            $this->setReference('research-'.$rn,
                    $this->createResearch($manager, $research['name'], $research['duration'], $research['points'], $research['cost'], $research['recipe'], $research['skills'], $research['replacing'], $research['conditions']));
        }
        
    }
}

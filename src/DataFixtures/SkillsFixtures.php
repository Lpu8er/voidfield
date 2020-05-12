<?php
namespace App\DataFixtures;

use App\Entity\Module;
use App\Entity\Skill;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

/**
 * Description of SkillsFixtures
 *
 * @author lpu8er
 */
class SkillsFixtures extends AbstractUtilitiesFixtures implements DependentFixtureInterface {
    public function load(ObjectManager $manager) {
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
            'stargate-discover' => [
                'name' => 'Découverte des portes des étoiles',
                'attr' => Skill::ATTRIBUTE_SPECIAL_STARGATE_DISCOVER,
                'val' => 1.00,
                'dtype' => null,
                'res' => null,
                'uc' => false,
            ],
            'stargate-use' => [
                'name' => 'Utilisation des portes des étoiles',
                'attr' => Skill::ATTRIBUTE_SPECIAL_STARGATE_USE,
                'val' => 1.00,
                'dtype' => null,
                'res' => null,
                'uc' => false,
            ],
        ];
        foreach($skills as $sn => $skill) {
            $this->setReference('skill-'.$sn,
                    $this->createSkill($manager, $skill['name'], $skill['attr'], $skill['val'], $skill['dtype'], empty($skill['res'])? null:$this->getReference('res-'.$skill['res']), $skill['uc']));
        }
    }
    
    public function getDependencies() {
        return [
            AppFixtures::class,
            ResourcesFixtures::class,
        ];
    }
}

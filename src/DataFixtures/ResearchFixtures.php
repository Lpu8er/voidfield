<?php
namespace App\DataFixtures;

use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

/**
 * Description of ResearchFixtures
 *
 * @author lpu8er
 */
class ResearchFixtures extends AbstractUtilitiesFixtures implements DependentFixtureInterface {
    public function load(ObjectManager $manager) {
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
    
    public function getDependencies() {
        return [
            AppFixtures::class,
            ResourcesFixtures::class,
            SkillsFixtures::class,
        ];
    }
}

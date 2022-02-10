<?php
namespace App\DataFixtures;

use App\Entity\Research;
use App\Entity\ResearchCond;
use App\Entity\ResearchRecipe;
use App\Entity\ResearchSkill;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

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
            
            'reading' => [
                'name'=> 'Lecture',
                'duration' => 'PT1M',
                'points' => null,
                'cost' => 100,
                'recipe' => [],
                'skills' => [],
                'replacing' => null,
                'conditions' => [],
            ],
            'writing' => [
                'name'=> 'Ecriture',
                'duration' => 'PT1M',
                'points' => null,
                'cost' => 100,
                'recipe' => [],
                'skills' => [],
                'replacing' => null,
                'conditions' => [],
            ],
            'maths' => [
                'name'=> 'Mathématiques',
                'duration' => 'PT3M',
                'points' => null,
                'cost' => 500,
                'recipe' => [],
                'skills' => [],
                'replacing' => null,
                'conditions' => [],
            ],
            'inge-1' => [
                'name'=> 'Ingénierie 1',
                'duration' => 'PT10M',
                'points' => null,
                'cost' => 1500,
                'recipe' => [],
                'skills' => [],
                'replacing' => null,
                'conditions' => [
                    'research-reading',
                    'research-writing',
                    'research-maths',
                ],
            ],
            'inge-2' => [
                'name'=> 'Ingénierie 2',
                'duration' => 'PT20M',
                'points' => null,
                'cost' => 3000,
                'recipe' => [],
                'skills' => [],
                'replacing' => 'research-inge-1',
                'conditions' => [
                    'research-inge-1',
                ],
            ],
            'inge-3' => [
                'name'=> 'Ingénierie 3',
                'duration' => 'PT40M',
                'points' => null,
                'cost' => 6000,
                'recipe' => [],
                'skills' => [],
                'replacing' => 'research-inge-2',
                'conditions' => [
                    'research-inge-2',
                ],
            ],
            'inge-4' => [
                'name'=> 'Ingénierie 4',
                'duration' => 'PT2H',
                'points' => null,
                'cost' => 12000,
                'recipe' => [],
                'skills' => [],
                'replacing' => 'research-inge-3',
                'conditions' => [
                    'research-inge-3',
                ],
            ],
            'inge-5' => [
                'name'=> 'Ingénierie 5',
                'duration' => 'PT4H',
                'points' => null,
                'cost' => 24000,
                'recipe' => [],
                'skills' => [],
                'replacing' => 'research-inge-4',
                'conditions' => [
                    'research-inge-4',
                ],
            ],
            'aerospace' => [
                'name'=> 'Aérospatial',
                'duration' => 'PT20M',
                'points' => null,
                'cost' => 1500,
                'recipe' => [],
                'skills' => [],
                'replacing' => null,
                'conditions' => [
                    'research-inge-3',
                ],
            ],
            'stargate-1' => [
                'name'=> 'Découverte des portes des étoiles',
                'duration' => 'PT15M',
                'points' => null,
                'cost' => 2500,
                'recipe' => [],
                'skills' => [
                    'skill-stargate-discover' => 1,
                ],
                'replacing' => null,
                'conditions' => [
                    'research-aerospace',
                ],
            ],
            'stargate-2' => [
                'name'=> 'Utilisation des portes des étoiles',
                'duration' => 'PT30M',
                'points' => null,
                'cost' => 5000,
                'recipe' => [],
                'skills' => [
                    'skill-stargate-use' => 1,
                ],
                'replacing' => null,
                'conditions' => [
                    'research-stargate-1',
                ],
            ],
            'flight' => [
                'name'=> 'Vol habité',
                'duration' => 'PT35M',
                'points' => null,
                'cost' => 3000,
                'recipe' => [],
                'skills' => [],
                'replacing' => null,
                'conditions' => [
                    'research-aerospace',
                ],
            ],
            'hunter' => [
                'name'=> 'Chasseur',
                'duration' => 'PT30M',
                'points' => null,
                'cost' => 6000,
                'recipe' => [],
                'skills' => [],
                'replacing' => null,
                'conditions' => [
                    'research-flight',
                    'research-inge-5',
                ],
            ],
            'cruiser' => [
                'name'=> 'Croiseur',
                'duration' => 'PT1H',
                'points' => null,
                'cost' => 12000,
                'recipe' => [],
                'skills' => [],
                'replacing' => null,
                'conditions' => [
                    'research-hunter',
                ],
            ],
            'frigate' => [
                'name'=> 'Frégate',
                'duration' => 'PT2H',
                'points' => null,
                'cost' => 24000,
                'recipe' => [],
                'skills' => [],
                'replacing' => null,
                'conditions' => [
                    'research-cruiser',
                ],
            ],
            'corvette' => [
                'name'=> 'Corvette',
                'duration' => 'PT4H',
                'points' => null,
                'cost' => 48000,
                'recipe' => [],
                'skills' => [],
                'replacing' => null,
                'conditions' => [
                    'research-frigate',
                ],
            ],
            'battleship' => [
                'name'=> 'Cuirassé',
                'duration' => 'PT8H',
                'points' => null,
                'cost' => 96000,
                'recipe' => [],
                'skills' => [],
                'replacing' => null,
                'conditions' => [
                    'research-corvette',
                ],
            ],
            'destroyer' => [
                'name'=> 'Destroyer',
                'duration' => 'PT16H',
                'points' => null,
                'cost' => 192000,
                'recipe' => [],
                'skills' => [],
                'replacing' => null,
                'conditions' => [
                    'research-battleship',
                ],
            ],
            'mothership' => [
                'name'=> 'Vaisseau-mère',
                'duration' => 'PT32H',
                'points' => null,
                'cost' => 384000,
                'recipe' => [],
                'skills' => [],
                'replacing' => null,
                'conditions' => [
                    'research-destroyer',
                ],
            ],
            'farragut' => [
                'name'=> 'Farragut',
                'duration' => 'PT64H',
                'points' => null,
                'cost' => 768000,
                'recipe' => [],
                'skills' => [],
                'replacing' => null,
                'conditions' => [
                    'research-mothership',
                ],
            ],
            'cargo' => [
                'name'=> 'Vaisseau cargo',
                'duration' => 'PT20M',
                'points' => null,
                'cost' => 2500,
                'recipe' => [],
                'skills' => [],
                'replacing' => null,
                'conditions' => [
                    'research-flight',
                    'research-inge-3',
                ],
            ],
            'colonisator' => [
                'name'=> 'Colonisateur',
                'duration' => 'PT40M',
                'points' => null,
                'cost' => 5000,
                'recipe' => [],
                'skills' => [],
                'replacing' => null,
                'conditions' => [
                    'research-cargo',
                ],
            ],
            'barge' => [
                'name'=> 'Barge',
                'duration' => 'PT1H20M',
                'points' => null,
                'cost' => 10000,
                'recipe' => [],
                'skills' => [],
                'replacing' => null,
                'conditions' => [
                    'research-colonisator',
                ],
            ],
            'terraformer' => [
                'name'=> 'Terraformeur',
                'duration' => 'PT2H40M',
                'points' => null,
                'cost' => 20000,
                'recipe' => [],
                'skills' => [],
                'replacing' => null,
                'conditions' => [
                    'research-barge',
                ],
            ],
            'carrier' => [
                'name'=> 'Porte-vaisseaux',
                'duration' => 'PT10H40M',
                'points' => null,
                'cost' => 80000,
                'recipe' => [],
                'skills' => [],
                'replacing' => null,
                'conditions' => [
                    'research-terraformer',
                    'research-inge-5',
                ],
            ],
            'ship-stock-1' => [
                'name'=> 'Capacité de cargo',
                'duration' => 'PT15M',
                'points' => null,
                'cost' => 3000,
                'recipe' => [],
                'skills' => [],
                'replacing' => null,
                'conditions' => [
                    'research-inge-3',
                ],
            ],
            'ship-stock-2' => [
                'name'=> 'Capacité de cargo avancée',
                'duration' => 'PT30M',
                'points' => null,
                'cost' => 6000,
                'recipe' => [],
                'skills' => [],
                'replacing' => null,
                'conditions' => [
                    'research-ship-stock-1',
                ],
            ],
            'ship-stock-3' => [
                'name'=> 'Capacité de cargo experte',
                'duration' => 'PT1H',
                'points' => null,
                'cost' => 12000,
                'recipe' => [],
                'skills' => [],
                'replacing' => null,
                'conditions' => [
                    'research-ship-stock-2',
                ],
            ],
            'ship-military-1' => [
                'name'=> 'Transport de troupes',
                'duration' => 'PT15M',
                'points' => null,
                'cost' => 3000,
                'recipe' => [],
                'skills' => [],
                'replacing' => null,
                'conditions' => [
                    'research-inge-3',
                ],
            ],
            'ship-military-2' => [
                'name'=> 'Stockage de troupes',
                'duration' => 'PT30M',
                'points' => null,
                'cost' => 6000,
                'recipe' => [],
                'skills' => [],
                'replacing' => null,
                'conditions' => [
                    'research-ship-military-1',
                ],
            ],
            'ship-military-3' => [
                'name'=> 'Accumulateur de troupes',
                'duration' => 'PT1H',
                'points' => null,
                'cost' => 12000,
                'recipe' => [],
                'skills' => [],
                'replacing' => null,
                'conditions' => [
                    'research-ship-military-2',
                ],
            ],
            'ship-cannons-1' => [
                'name'=> 'Mitrailleuse',
                'duration' => 'PT20M',
                'points' => null,
                'cost' => 6000,
                'recipe' => [],
                'skills' => [],
                'replacing' => null,
                'conditions' => [
                    'research-inge-5',
                ],
            ],
            'ship-cannons-2' => [
                'name'=> 'Canon moyen calibre',
                'duration' => 'PT40M',
                'points' => null,
                'cost' => 12000,
                'recipe' => [],
                'skills' => [],
                'replacing' => null,
                'conditions' => [
                    'research-ship-cannons-1',
                ],
            ],
            'ship-cannons-3' => [
                'name'=> 'Canon gros calibre',
                'duration' => 'PT1H20M',
                'points' => null,
                'cost' => 24000,
                'recipe' => [],
                'skills' => [],
                'replacing' => null,
                'conditions' => [
                    'research-ship-cannons-2',
                ],
            ],
            'ship-laser-1' => [
                'name'=> 'Laser rouge',
                'duration' => 'PT40M',
                'points' => null,
                'cost' => 8000,
                'recipe' => [],
                'skills' => [],
                'replacing' => null,
                'conditions' => [
                    'research-inge-5',
                ],
            ],
            'ship-laser-2' => [
                'name'=> 'Laser vert',
                'duration' => 'PT1H20M',
                'points' => null,
                'cost' => 16000,
                'recipe' => [],
                'skills' => [],
                'replacing' => null,
                'conditions' => [
                    'research-ship-laser-1',
                ],
            ],
            'ship-laser-3' => [
                'name'=> 'Laser bleu',
                'duration' => 'PT2H40M',
                'points' => null,
                'cost' => 32000,
                'recipe' => [],
                'skills' => [],
                'replacing' => null,
                'conditions' => [
                    'research-ship-laser-2',
                ],
            ],
            'ship-rail-1' => [
                'name'=> 'Railgun (20mm)',
                'duration' => 'PT1H20M',
                'points' => null,
                'cost' => 12000,
                'recipe' => [],
                'skills' => [],
                'replacing' => null,
                'conditions' => [
                    'research-inge-5',
                ],
            ],
            'ship-rail-2' => [
                'name'=> 'Railgun (40mm)',
                'duration' => 'PT2H40M',
                'points' => null,
                'cost' => 24000,
                'recipe' => [],
                'skills' => [],
                'replacing' => null,
                'conditions' => [
                    'research-ship-rail-1',
                ],
            ],
            'ship-rail-3' => [
                'name'=> 'Railgun (80mm)',
                'duration' => 'PT5H20M',
                'points' => null,
                'cost' => 48000,
                'recipe' => [],
                'skills' => [],
                'replacing' => null,
                'conditions' => [
                    'research-ship-rail-2',
                ],
            ],
            'archeology' => [
                'name'=> 'Archéologie',
                'duration' => 'PT15M',
                'points' => null,
                'cost' => 2500,
                'recipe' => [],
                'skills' => [
                    'skill-planetology' => 25,
                ],
                'replacing' => null,
                'conditions' => [],
            ],
            'geology' => [
                'name'=> 'Géologie',
                'duration' => 'PT30M',
                'points' => null,
                'cost' => 5000,
                'recipe' => [],
                'skills' => [
                    'skill-planetology' => 25,
                ],
                'replacing' => null,
                'conditions' => [
                    'research-archeology',
                ],
            ],
            'planetology' => [
                'name'=> 'Planétologie',
                'duration' => 'PT1H',
                'points' => null,
                'cost' => 50000,
                'recipe' => [],
                'skills' => [
                    'skill-planetology' => 25,
                ],
                'replacing' => null,
                'conditions' => [
                    'research-geology',
                ],
            ],
        ];
        foreach($researches as $rn => $research) {
            $this->setReference('research-'.$rn,
                    $this->createResearch($manager,
                            $research['name'],
                            $research['duration'],
                            empty($research['points'])? static::getSecondsFromInterval($research['duration']):$research['points'],
                            $research['cost'],
                            $research['recipe'],
                            $research['skills'],
                            $research['replacing'],
                            $research['conditions']));
        }
    }
    
    public function getDependencies() {
        return [
            AppFixtures::class,
            ResourcesFixtures::class,
            SkillsFixtures::class,
        ];
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
}

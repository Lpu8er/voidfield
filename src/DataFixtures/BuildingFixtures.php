<?php
namespace App\DataFixtures;

use App\Entity\Building;
use App\Entity\BuildingCond;
use App\Entity\BuildingConsumption;
use App\Entity\BuildingExtraction;
use App\Entity\BuildingProduction;
use App\Entity\BuildingSkill;
use App\Entity\BuildRecipe;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

/**
 * Description of BuildingFixtures
 *
 * @author lpu8er
 */
class BuildingFixtures extends AbstractUtilitiesFixtures implements DependentFixtureInterface {
    public function load(ObjectManager $manager) {
        $buildings = [
            'spaceport' => [
                'name' => 'Spatioport',
                'duration' => 'PT1H',
                'restrict' => Building::RESTRICT_LAND | Building::RESTRICT_WATER | Building::RESTRICT_ATMOSPHERIC,
                'cost' => 120000,
                'workers' => 5000,
                'work-conso' => 1000,
                'energy-conso' => 800,
                'special' => Building::SPECIAL_SPACEPORT,
            ],
            'stellarport' => [
                'name' => 'Port Stellaire',
                'duration' => 'PT2H',
                'restrict' => Building::RESTRICT_ORBITAL,
                'cost' => 200000,
                'workers' => 8000,
                'work-conso' => 1200,
                'energy-conso' => 1000,
                'special' => Building::SPECIAL_SPACEPORT,
            ],
            'space-elevator' => [
                'name' => 'Ascenseur spatial',
                'duration' => 'PT5H',
                'restrict' => Building::RESTRICT_LAND,
                'cost' => 1000000,
                'workers' => 45000,
                'work-conso' => 5000,
                'energy-conso' => 1500,
                'special' => Building::SPECIAL_SPACEPORT,
                'replace' => 'building-spaceport',
            ],
            'governement' => [
                'name' => 'Gouvernement',
                'duration' => 'PT35M',
                'cost' => 35000,
                'workers' => 1000,
                'work-conso' => 100,
                'energy-conso' => 200,
                'special' => Building::SPECIAL_GOV,
            ],
            'hab-e-1' => [
                'name' => 'Quartier pied-à-terre',
                'duration' => 'PT5M',
                'cost' => 15000,
                'workers' => 300,
                'work-conso' => 25,
                'energy-conso' => 20,
                'habs' => 500,
                'restrict' => Building::RESTRICT_LAND,
            ],
            'hab-e-2' => [
                'name' => 'Gratte-ciel',
                'duration' => 'PT15M',
                'cost' => 25000,
                'workers' => 600,
                'work-conso' => 50,
                'energy-conso' => 30,
                'habs' => 1500,
                'restrict' => Building::RESTRICT_LAND,
            ],
            'hab-w-1' => [
                'name' => 'Quartier flottant',
                'duration' => 'PT7M',
                'cost' => 17500,
                'workers' => 500,
                'work-conso' => 25,
                'energy-conso' => 20,
                'habs' => 500,
                'restrict' => Building::RESTRICT_WATER,
            ],
            'hab-w-2' => [
                'name' => 'Immeuble flottant',
                'duration' => 'PT15M',
                'cost' => 285000,
                'workers' => 700,
                'work-conso' => 50,
                'energy-conso' => 30,
                'habs' => 1500,
                'restrict' => Building::RESTRICT_WATER,
            ],
            'hab-a-1' => [
                'name' => 'Quartier aérien',
                'duration' => 'PT7M',
                'cost' => 20000,
                'workers' => 350,
                'work-conso' => 20,
                'energy-conso' => 20,
                'habs' => 500,
                'restrict' => Building::RESTRICT_ATMOSPHERIC,
            ],
            'hab-a-2' => [
                'name' => 'Immeuble graviton',
                'duration' => 'PT18M',
                'cost' => 300000,
                'workers' => 700,
                'work-conso' => 45,
                'energy-conso' => 30,
                'habs' => 1500,
                'restrict' => Building::RESTRICT_ATMOSPHERIC,
            ],
            'hab-s-1' => [
                'name' => 'Quartier spatiaux',
                'duration' => 'PT15M',
                'cost' => 25000,
                'workers' => 500,
                'work-conso' => 30,
                'energy-conso' => 20,
                'habs' => 500,
                'restrict' => Building::RESTRICT_ORBITAL,
            ],
            'hab-s-2' => [
                'name' => 'Medina',
                'duration' => 'PT25M',
                'cost' => 35000,
                'workers' => 900,
                'work-conso' => 55,
                'energy-conso' => 30,
                'habs' => 1500,
                'restrict' => Building::RESTRICT_ORBITAL,
            ],
            'hostel' => [
                'name' => 'Hôtel',
                'duration' => 'PT15M',
                'cost' => 50000,
                'workers' => 200,
                'work-conso' => 10,
                'energy-conso' => 15,
                'skills' => [
                    'skill-daily-income' => 2, // +2% daily income
                ],
            ],
            'hostel' => [
                'name' => 'Hôtel',
                'duration' => 'PT15M',
                'cost' => 50000,
                'workers' => 200,
                'work-conso' => 10,
                'energy-conso' => 15,
                'skills' => [
                    'skill-daily-income' => 2, // +2% daily income
                ],
            ],
            'fusion-plant' => [
                'name' => 'Centrale à fusion',
                'duration' => 'PT25M',
                'cost' => 90000,
                'workers' => 1000,
                'work-conso' => 150,
                'energy-prod' => 2500,
                'energy-stock' => 250000,
                'skills' => [],
            ],
            'barrage' => [
                'name' => 'Barrage',
                'duration' => 'PT15M',
                'cost' => 30000,
                'workers' => 300,
                'work-conso' => 75,
                'energy-prod' => 800,
                'energy-stock' => 100000,
                'skills' => [],
                'restrict' => Building::RESTRICT_LAND | Building::RESTRICT_WATER,
            ],
            'windmills' => [
                'name' => 'Eoliennes',
                'duration' => 'PT10M',
                'cost' => 12000,
                'workers' => 300,
                'work-conso' => 30,
                'energy-prod' => 500,
                'skills' => [],
                'restrict' => Building::RESTRICT_LAND | Building::RESTRICT_WATER, Building::RESTRICT_ATMOSPHERIC,
            ],
            'labo' => [
                'name' => 'Laboratoire',
                'duration' => 'PT10M',
                'cost' => 100000,
                'workers' => 500,
                'work-conso' => 75,
                'energy-conso' => 100,
                'skills' => [
                    'skill-research-speed' => 2,
                ],
                'special' => Building::SPECIAL_RESEARCH,
            ],
            'space-factory' => [
                'name' => 'Chantier spatial',
                'duration' => 'PT20M',
                'cost' => 150000,
                'workers' => 8000,
                'work-conso' => 1500,
                'energy-conso' => 150,
                'special' => Building::SPECIAL_SPACEFACTORY,
            ],
            'mine-iron' => [
                'name' => 'Mine de roches ferreuses',
                'duration' => 'PT1M',
                'cost' => 15000,
                'workers' => 200,
                'work-conso' => 40,
                'energy-conso' => 20,
                'extract' => [
                    'res-iron' => 100,
                ],
                'maxNb' => 10, // that number will impact other stats (duration : exp, cost : exp, and so on)
            ],
        ];
        
        foreach($buildings as $k => $bd) {
            $b = $this->createBuilding($manager,
                    $bd['name'],
                    $bd['duration'],
                    empty($bd['points'])? static::getSecondsFromInterval($bd['duration']):$bd['points'],
                    empty($bd['description'])? '':$bd['description'],
                    empty($bd['size'])? 0:intval($bd['size']),
                    empty($bd['restrict'])? null:$bd['restrict'],
                    empty($bd['special'])? null:$bd['special'],
                    empty($bd['hp'])? 100:$bd['hp'],
                    $bd['cost'],
                    $bd['workers'],
                    empty($bd['work-conso'])? 0:$bd['work-conso'],
                    empty($bd['habs'])? 0:$bd['habs'],
                    empty($bd['energy-conso'])? 0:$bd['energy-conso'],
                    empty($bd['energy-prod'])? 0:$bd['energy-prod'],
                    empty($bd['energy-stock'])? 0:$bd['energy-stock'],
                    empty($bd['cond'])? []:$bd['cond'],
                    empty($bd['recipe'])? []:$bd['recipe'],
                    empty($bd['prod'])? []:$bd['prod'],
                    empty($bd['conso'])? []:$bd['conso'],
                    empty($bd['extract'])? []:$bd['extract'],
                    empty($bd['skills'])? []:$bd['skills'],
                    empty($bd['dtype'])? null:$bd['dtype'],
                    empty($bd['atk'])? 0.00:$bd['atk'],
                    empty($bd['replace'])? null:$bd['replace'],
                    array_key_exists('maxNb', $bd)? $bd['maxNb']:1);
            $this->setReference('building-'.$k, $b);
        }
    }
    
    public function getDependencies() {
        return [
            SkillsFixtures::class,
        ];
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
            int $size, ?int $restrictedTo, ?string $special, int $hitpoints,
            int $cost, int $workers, int $workersConsumption, int $workersStock,
            int $energyConsumption, int $energyProd, int $energyStock,
            array $conds, array $recipe,
            array $production = [], array $consumption = [], array $extraction = [], array $skills = [],
            string $assaultType = null, int $assaultValue = 0, string $replacing = null,
            int $maxNb = 1): Building {
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
        $b->setReplacing(empty($replacing)? null:$this->getReference($replacing));
        $b->setRestrictedTo($restrictedTo);
        $b->setSize($size);
        $b->setSpecial($special);
        
        $b->setWorkers($workersConsumption);
        $b->setWorkersStock($workersStock);
        
        $b->setMaxNb($maxNb);
        
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

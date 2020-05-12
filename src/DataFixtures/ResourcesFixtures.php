<?php
namespace App\DataFixtures;

use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

/**
 * Description of ResourcesFixtures
 *
 * @author lpu8er
 */
class ResourcesFixtures extends AbstractUtilitiesFixtures implements DependentFixtureInterface {
    public function load(ObjectManager $manager) {
        // generate resources
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
    }
    
    public function getDependencies() {
        return [
            AppFixtures::class
        ];
    }
}

<?php
namespace App\DataFixtures;

use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

/**
 * Description of ShipFixtures
 *
 * @author lpu8er
 */
class ShipFixtures extends AbstractUtilitiesFixtures implements DependentFixtureInterface {
    public function load(ObjectManager $manager) {
        
    }
    
    public function getDependencies() {
        return [
            AppFixtures::class,
            ResourcesFixtures::class,
            ResearchFixtures::class,
        ];
    }
}

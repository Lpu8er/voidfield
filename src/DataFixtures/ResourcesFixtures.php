<?php
namespace App\DataFixtures;

use App\Entity\Resource;
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
        $iron = $this->createResource($manager, 'Ferreux', 100.0, 100.0, 0.0, 'Fe'); // 🜜
        $this->setReference('res-iron', $iron);
        $hydro = $this->createResource($manager, 'Hydrocarbure', 1.0, 10.0, 0.0, 'Hx'); // 🝆
        $this->setReference('res-hydro', $hydro);
        $quartz = $this->createResource($manager, 'Quartz', 150.0, 5.0, 0.0, 'Qz'); // 🜘
        $this->setReference('res-quartz', $quartz);
        $titane = $this->createResource($manager, 'Titane', 100.0, 100.0, 0.0, 'Ti');
        $this->setReference('res-titane', $titane);
        $water = $this->createResource($manager, 'Eau potable', 1.0, 1.0, 0.4, 'H²');
        $this->setReference('res-water', $water);
        $wheat = $this->createResource($manager, 'Féculents', 0.8, 1.5, 1.5, 'Bl');
        $this->setReference('res-wheat', $wheat);
        $legfruits = $this->createResource($manager, 'Fruits et légumes', 1.2, 1.2, 1.0, 'Vg');
        $this->setReference('res-legfruits', $legfruits);
        $gold = $this->createResource($manager, 'Précieux', 80.0, 110.0, 0.0, 'Au'); // 🜚
        $this->setReference('res-gold', $gold);
    }
    
    public function getDependencies() {
        return [
            AppFixtures::class
        ];
    }
    
    /**
     * 
     * @param ObjectManager $em
     * @param string $name
     * @param float $mass
     * @param float $size
     * @param float $nutritive
     * @param string $unicode
     * @return Resource
     */
    protected function createResource($em, string $name, float $mass, float $size, float $nutritive, string $unicode): Resource {
        $res = new Resource;
        $res->setName($name);
        $res->setMass($mass);
        $res->setSize($size);
        $res->setNutritive($nutritive);
        $res->setRestricted(Resource::RESTRICT_AIR | Resource::RESTRICT_WATER | Resource::RESTRICT_EARTH);
        $res->setUnicode($unicode);
        $em->persist($res);
        $em->flush();
        return $res;
    }
}

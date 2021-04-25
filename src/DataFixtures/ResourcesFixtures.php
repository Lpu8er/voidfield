<?php
namespace App\DataFixtures;

use App\Entity\Resource;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

/**
 * Description of ResourcesFixtures
 *
 * @author lpu8er
 */
class ResourcesFixtures extends AbstractUtilitiesFixtures implements DependentFixtureInterface {
    public function load(ObjectManager $manager) {
        $res = [
            'iron' => [
                'name' => 'Ferreux',
                'mass' => 100.0,
                'size' => 100.0,
                'nutritive' => 0.0,
                'unicode' => '⛏', // 🜜
            ],
            'hydro' => [
                'name' => 'Hydrocarbure',
                'mass' => 1.0,
                'size' => 10.0,
                'nutritive' => 0.0,
                'unicode' => '🛢', // 🝆
            ],
            'quartz' => [
                'name' => 'Quartz',
                'mass' => 150.0,
                'size' => 5.0,
                'nutritive' => 0.0,
                'unicode' => '💎', // 🜘
            ],
            'titane' => [
                'name' => 'Titane',
                'mass' => 100.0,
                'size' => 100.0,
                'nutritive' => 0.0,
                'unicode' => 'Ti', // ♄
            ],
            'water' => [
                'name' => 'Eau potable',
                'mass' => 1.0,
                'size' => 1.0,
                'nutritive' => 0.4,
                'unicode' => '💧', // 🜄
            ],
            'wheat' => [
                'name' => 'Féculents',
                'mass' => 0.8,
                'size' => 1.5,
                'nutritive' => 1.5,
                'unicode' => '🌾', // 
            ],
            'legfruits' => [
                'name' => 'Fruits et légumes',
                'mass' => 1.2,
                'size' => 1.2,
                'nutritive' => 1.0,
                'unicode' => '🥑', // 
            ],
            'gold' => [
                'name' => 'Précieux',
                'mass' => 80.0,
                'size' => 110.0,
                'nutritive' => 0.0,
                'unicode' => '✨', // 🜚
            ],
        ];
        
        // generate resources
        foreach($res as $rk => $rv) {
            $this->setReference('res-'.$rk, 
                    $this->createResource(
                            $manager,
                            $rv['name'],
                            $rv['mass'],
                            $rv['size'],
                            $rv['nutritive'],
                            $rv['unicode'],
                            $rk)
                );
        }
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
     * @param string $skey
     * @return Resource
     */
    protected function createResource($em, string $name, float $mass, float $size, float $nutritive, string $unicode, string $skey): Resource {
        $res = new Resource;
        $res->setName($name);
        $res->setMass($mass);
        $res->setSize($size);
        $res->setNutritive($nutritive);
        $res->setRestricted(Resource::RESTRICT_AIR | Resource::RESTRICT_WATER | Resource::RESTRICT_EARTH);
        $res->setUnicode($unicode);
        $res->setSkey($skey);
        $em->persist($res);
        $em->flush();
        return $res;
    }
}

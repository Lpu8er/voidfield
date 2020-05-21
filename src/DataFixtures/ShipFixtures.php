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
        $hulls = [];
        
        foreach($hulls as $rh => $hull) {
            $this->setReference('hull-'.$rh,
                    $this->createHull($manager,
                            $hull['name'],
                            empty($hull['mass'])? 0:$hull['mass'],
                            empty($hull['size'])? 0:$hull['size'],
                            empty($hull['sig'])? 1:$hull['sig'],
                            empty($hull['hp'])? 1:$hull['hp'],
                            empty($hull['slots'])? []:$hull['slots']));
        }
    }
    
    public function getDependencies() {
        return [
            AppFixtures::class,
            ResourcesFixtures::class,
            ResearchFixtures::class,
        ];
    }
    
    /**
     * 
     * @param ObjectManager $em
     * @param string $name
     * @param float $mass
     * @param float $size
     * @param int $sig
     * @param int $hp
     * @param array $slots
     * @return \App\Entity\Hull
     */
    protected function createHull(ObjectManager $em, string $name, float $mass, float $size, int $sig, int $hp = 1, array $slots = []): \App\Entity\Hull {
        $h = new \App\Entity\Hull;
        $h->setName($name);
        $h->setMass($mass);
        $h->setSize($size);
        $h->setSignature($sig);
        $h->setHitpoints($hp);
        foreach(\App\Entity\Hull::listSlots() as $slot) {
            if(array_key_exists($slot, $slots)) {
                $mn = 'set'.ucfirst($slot).'Slots';
                $h->{$mn}(intval($slots[$slot]));
            }
        }
        $em->persist($h);
        $em->flush();
        return $h;
    }
}

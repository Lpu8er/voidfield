<?php
namespace App\DataFixtures;

use App\Entity\Hull;
use App\Entity\HullCond;
use App\Entity\HullRecipe;
use App\Entity\Module;
use App\Entity\ModuleCond;
use App\Entity\ModuleRecipe;
use App\Entity\ShipModel;
use App\Entity\ShipModelRecipe;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

/**
 * Description of ShipFixtures
 *
 * @author lpu8er
 */
class ShipFixtures extends AbstractUtilitiesFixtures implements DependentFixtureInterface {
    public function load(ObjectManager $manager) {
        $hulls = [
            'probe' => [
                'name' => 'Sonde',
                'mass' => 100,
                'size' => 10,
                'sig' => 1,
                'recipe' => [
                    'res-iron' => 1000,
                ],
                'conds' => [
                    'aerospace',
                ],
            ],
        ];
        
        $modules = [];
        
        $models = [];
        
        foreach($hulls as $rh => $hull) {
            $this->setReference('hull-'.$rh,
                $this->createHull($manager,
                    $hull['name'],
                    empty($hull['mass'])? 0:$hull['mass'],
                    empty($hull['size'])? 0:$hull['size'],
                    empty($hull['sig'])? 1:$hull['sig'],
                    empty($hull['hp'])? 1:$hull['hp'],
                    empty($hull['slots'])? []:$hull['slots'],
                    empty($hull['recipe'])? []:$hull['recipe'],
                    empty($hull['conds'])? []:$hull['conds']));
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
     * @param array $recipe
     * @param array $cond
     * @return Hull
     */
    protected function createHull(ObjectManager $em, string $name, float $mass, float $size, int $sig, int $hp = 1, array $slots = [], array $recipe = [], array $conds = []): Hull {
        $h = new Hull;
        $h->setName($name);
        $h->setMass($mass);
        $h->setSize($size);
        $h->setSignature($sig);
        $h->setHitpoints($hp);
        foreach(Hull::listSlots() as $slot) {
            if(array_key_exists($slot, $slots)) {
                $mn = 'set'.ucfirst($slot).'Slots';
                $h->{$mn}(intval($slots[$slot]));
            }
        }
        $em->persist($h);
        $em->flush();
        
        foreach($recipe as $res => $nb) {
            $hr = new HullRecipe();
            $hr->setHull($h);
            $hr->setResource($this->getReference($res));
            $hr->setNb($nb);
            $em->persist($hr);
        }
        
        foreach($conds as $tech) {
            $hc = new HullCond();
            $hc->setTarget($h);
            $hc->setNeed($this->getReference($tech));
            $em->persist($hc);
        }
        
        $em->flush();
        
        return $h;
    }
    
    /**
     * 
     * @param ObjectManager $em
     * @param string $name
     * @param string $slot
     * @param int $size
     * @param int $mass
     * @param int $signatureBase
     * @param int $energyConsumption
     * @param array $recipe
     * @param array $conds
     * @param string|null $special
     * @param int $energyBase
     * @param float|null $energyModifier
     * @param int $attackBase
     * @param float|null $attackModifier
     * @param string|null $attackType
     * @param int $defenseBase
     * @param float|null $defenseModifier
     * @param string|null $defenseType
     * @param int $maxCargoMass
     * @param int $maxCargoSize
     * @param int $scanStrength
     * @param int $speedBase
     * @param float|null $speedModifier
     * @param int|null $slotUsage
     * @return Module
     */
    protected function createModule(ObjectManager $em, string $name, string $slot, int $size, int $mass, int $signatureBase, int $energyConsumption,
            array $recipe = [],
            array $conds = [],
            ?string $special = null,
            int $energyBase = 0,
            ?float $energyModifier = null,
            int $attackBase = 0,
            ?float $attackModifier = null,
            ?string $attackType = null,
            int $defenseBase = 0,
            ?float $defenseModifier = null,
            ?string $defenseType = null,
            int $maxCargoMass = 0,
            int $maxCargoSize = 0,
            int $scanStrength = 0,
            int $speedBase = 0,
            ?float $speedModifier = null,
            ?int $slotUsage = null): Module {
        $m = new Module;
        
        $m->setName($name);
        $m->setSlot($slot);
        if(isset($slotUsage)) {
            $m->setSlotUsage($slotUsage);
        }
        $m->setSize($size);
        $m->setMass($mass);
        $m->setSignatureBase($signatureBase);
        $m->setEnergyConsumation($energyConsumption);
        
        $m->setEnergyBase(empty($energyBase)? 0:$energyBase);
        if(isset($energyModifier)) {
            $m->setEnergyModifier($energyModifier);
        }
        
        $m->setAttackBase(empty($attackBase)? 0:$attackBase);
        if(isset($attackModifier)) {
            $m->setAttackModifier($attackModifier);
        }
        $m->setAttackType(empty($attackType)? null:$attackType);
        
        $m->setDefenseBase(empty($defenseBase)? 0:$defenseBase);
        if(isset($defenseModifier)) {
            $m->setDefenseModifier($defenseModifier);
        }
        $m->setDefenseType(empty($defenseType)? null:$defenseType);
        
        $m->setMaxCargoMass(empty($maxCargoMass)? 0:$maxCargoMass);
        $m->setMaxCargoSize(empty($maxCargoSize)? 0:$maxCargoSize);
        $m->setScanStrength(empty($scanStrength)? 0:$scanStrength);
        
        $m->setSpecial(empty($special)? null:$special);
        $m->setSpeedBase(empty($speedBase)? 0:$speedBase);
        if(isset($speedModifier)) {
            $m->setSpeedModifier($speedModifier);
        }
        $em->persist($m);
        $em->flush();
        
        foreach($recipe as $res => $nb) {
            $mr = new ModuleRecipe();
            $mr->setModule($m);
            $mr->setResource($this->getReference($res));
            $mr->setNb($nb);
            $em->persist($mr);
        }
        
        foreach($conds as $tech) {
            $mc = new ModuleCond();
            $mc->setTarget($m);
            $mc->setNeed($this->getReference($tech));
            $em->persist($mc);
        }
        
        return $m;
    }
    
    /**
     * 
     * @param ObjectManager $em
     * @param string $name
     * @param string $hullRef
     * @param float $baseCost
     * @param int $energyBuild
     * @param array $modules
     * @return ShipModel
     */
    public function createModel(ObjectManager $em, string $name, string $hullRef, float $baseCost, int $energyBuild, array $modules): ShipModel {
        /**
         * @var Hull
         */
        $hull = $this->getReference($hullRef);
        
        // compute data from modules and hull
        $energyConsumption = 0;
        $mass = $hull->getMass();
        $size = $hull->getSize();
        $speed = 0;
        $speedModifier = 1.;
        $signature = $hull->getSignature();
        $signatureModifier = 1.;
        $maxCargoMass = 0;
        $maxCargoSize = 0;
        $recipe = [];
        
        foreach($hull->getRecipe() as $srecipe) {
            $recipe[$srecipe->getResource()->getId()] = [
                $srecipe->getResource(),
                $srecipe->getNb(),
                $srecipe->getRecyclable(),
            ];
        }
        
        foreach($modules as $moduleRef) {
            $module = $this->getReference($moduleRef);
            $energyConsumption += $module->getEnergyConsumation();
            $mass += $module->getMass();
            $size += $module->getSize();
            $speed += $module->getSpeedBase();
            $speedModifier *= $module->getSpeedModifier();
            $signature += $module->getSignatureBase();
            $signatureModifier *= $module->getSignatureModifier();
            $maxCargoMass += $module->getMaxCargoMass();
            $maxCargoSize += $module->getMaxCargoSize();
            foreach($module->getRecipe() as $srecipe) {
                if(!array_key_exists()) {
                    $recipe[$srecipe->getResource()->getId()] = [$srecipe->getResource(), 0, 0,];
                }
                $recipe[$srecipe->getResource()->getId()][0] += $srecipe->getNb();
                $recipe[$srecipe->getResource()->getId()][0] += $srecipe->getRecyclable();
            }
        }
        
        // now, change again speed and signature depending on modifiers
        $speed *= $speedModifier;
        $signature *= $signatureModifier;
        
        // we good to go
        $m = new ShipModel;
        $m->setName($name);
        $m->setHull($hull);
        $m->setBaseCost($baseCost);
        $m->setEnergyBuild($energyBuild);
        $m->setEnergyConsumation($energyConsumption);
        
        $m->setMass($mass);
        $m->setSize($size);
        $m->setSpeed($speed);
        $m->setSignature($signature);
        
        $m->setMaxCargoMass($maxCargoMass);
        $m->setMaxCargoSize($maxCargoSize);
        
        $em->persist($m);
        $em->flush();
        
        // save recipe
        $toFlush = false;
        foreach($recipe as $res) {
            $smr = new ShipModelRecipe;
            $smr->setShipModel($m);
            $smr->setResource($res[0]);
            $smr->setNb($res[1]);
            $smr->setRecyclable($res[2]);
            $em->persist($smr);
            $toFlush = true;
        }
        $em->flush();
        
        // save modules link
        foreach($modules as $moduleRef) {
            $module = $this->getReference($moduleRef);
            $m->addModule($module);
        }
        $em->persist($m); // resave
        $em->flush();
        
        return $m;
    }
}

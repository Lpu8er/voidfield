<?php
namespace App\DataFixtures;

use App\Entity\Module;
use App\Entity\Skill;
use App\Entity\User;
use Doctrine\Common\Persistence\ObjectManager;

/**
 * Description of AppFixtures
 *
 * @author lpu8er
 */
class AppFixtures extends AbstractUtilitiesFixtures {
    const AU = 149597870;
    
    public function load(ObjectManager $manager) {
        // add initial bot to assert domination
        $this->createUser($manager, 'Lain', 'lpu8er+voidfield@gmail.com', md5(uniqid()), User::STATUS_BOT);
    }
}

<?php
namespace App\DataFixtures;

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
    
    /**
     * 
     * @param ObjectManager $em
     * @param string $username
     * @param string $mail
     * @param string $pwd
     * @param string $status
     * @return User
     */
    protected function createUser($em, string $username, string $mail, string $pwd, string $status): User {
        $user = new User;
        $user->setUsername($username);
        $user->setEmail($mail);
        $user->setStatus($status);
        $encoded = $this->encoder->encodePassword($user, $pwd);
        $user->setPwd($encoded);
        $em->persist($user);
        $em->flush();
        return $user;
    }
}

<?php
namespace App\Tests;

use Doctrine\ORM\EntityManager;
use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Component\Console\Input\ArrayInput;

/**
 * Description of tDatabaseTest
 *
 * @author lpu8er
 */
trait tDatabaseTest {
    /**
     *
     * @var type 
     */
    protected $testKernel = null;
    
    /**
     * @var EntityManager
     */
    protected $entityManager = null;
    
    protected function setUp() {
        $this->testKernel = self::bootKernel();
        $this->entityManager = $this->testKernel->getContainer()
            ->get('doctrine')
            ->getManager();
        $app = new Application($this->testKernel);
        $app->setAutoExit(false);
        $app->run(new ArrayInput([
            'command' => 'doctrine:schema:update',
            '--force' => true,
        ]));
        $app->run(new ArrayInput([
            'command' => 'doctrine:fixtures:load',
            '--append' => true,
        ]));
    }
}

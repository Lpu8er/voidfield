<?php
namespace App\Tests\Repository;

use App\Entity\User;
use App\Tests\tDatabaseTest;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

/**
 * Description of UserRepositoryTest
 *
 * @author lpu8er
 */
class UserRepositoryTest extends KernelTestCase {
    use tDatabaseTest {
        setUp as protected parentSetUp;
    }
    
    /**
     *
     * @var UserPasswordEncoderInterface 
     */
    protected $encoder = null;
    
    /**
     *
     * @var \App\Repository\UserRepository
     */
    protected $repo = null;
    
    public function setUp(): void {
        $this->parentSetUp();
        $this->encoder = $this->testKernel->getContainer()->get('encoder');
    }
    
    /**
     * 
     * @return \App\Repository\UserRepository
     */
    protected function getRepository() {
        if(null === $this->repo) {
            $this->repo = $this->entityManager->getRepository(User::class);
        }
        return $this->repo;
    }
    
    public function testCreateUser() {
        $u = $this->getRepository()->createUser('test-user', 'lpu8er+test-user@gmail.com', 'test', $this->encoder);
        $this->assertInstanceOf(User::class, $u);
    }
    
    public function testSearchUser() {
        $this->getRepository()->createUser('test-user', 'lpu8er+test-user@gmail.com', 'test', $this->encoder);
        $found = $this->getRepository()->searchAnyEmailUsername('non-existant', 'test-user');
        $this->assertTrue($found, 'User is found by username only');
        $found = $this->getRepository()->searchAnyEmailUsername('lpu8er+test-user@gmail.com', 'non-existant');
        $this->assertTrue($found, 'User is found by email only');
        $found = $this->getRepository()->searchAnyEmailUsername('lpu8er+test-user@gmail.com', 'test-user');
        $this->assertTrue($found, 'User is found by username AND email');
        $found = $this->getRepository()->searchAnyEmailUsername('non-existant', 'non-existant');
        $this->assertFalse($found, 'User is not found');
    }
    
    protected function tearDown(): void {
        parent::tearDown();
        $this->entityManager->close();
        $this->entityManager = null;
    }
}

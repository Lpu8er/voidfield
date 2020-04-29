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
    
    protected function setUp() {
        $this->parentSetUp();
        $this->encoder = $this->testKernel->getContainer()->get('encoder');
    }
    
    public function testCreateUser() {
        $userRepository = $this->entityManager->getRepository(User::class);
        $u = $userRepository->createUser('test-user', 'lpu8er+test-user@gmail.com', 'test', $this->encoder);
        $this->assertInstanceOf(User::class, $u);
    }
    
    protected function tearDown(): void {
        parent::tearDown();
        $this->entityManager->close();
        $this->entityManager = null;
    }
}

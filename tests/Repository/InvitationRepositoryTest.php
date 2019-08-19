<?php
// tests/Repository/InvitationRepositoryTest.php
namespace App\Tests\Repository;

use App\Entity\Invitation;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class InvitationRepositoryTest extends KernelTestCase
{
    /**
     * @var \Doctrine\ORM\EntityManager
     */
    private $entityManager;

    /**
     * {@inheritDoc}
     */
    protected function setUp()
    {
        $kernel = self::bootKernel();

        $this->entityManager = $kernel->getContainer()
            ->get('doctrine')
            ->getManager();
    }

    public function testCreateOneRecord()
    {
        $items = $this->entityManager
            ->getRepository(Invitation::class)
            ->findBy(['title' => 'Always Remember music.'])
        ;
        $this->assertGreaterThanOrEqual(1, $items);
    }

    /**
     * Test: Is entityManager working? 
     */
    public function testSearchByTitle()
    {
        $items = $this->entityManager
            ->getRepository(Invitation::class)
            ->findBy(['title' => 'Always Remember music.'])
        ;
        $this->assertGreaterThanOrEqual(1, $items);
    }

    /**
     * Test: Is getResultAndCount working? 
     * Test: Do we have records on the table invitatios?
     */

    public function testGetResultAndCount()
    {
        $res = $this->entityManager
            ->getRepository(Invitation::class)
            ->getResultAndCount()
        ;
        $this->assertGreaterThanOrEqual(1, $res[0]);
    }

    /**
     * {@inheritDoc}
     */
    protected function tearDown()
    {
        parent::tearDown();

        $this->entityManager->close();
        $this->entityManager = null; // avoid memory leaks
    }
}

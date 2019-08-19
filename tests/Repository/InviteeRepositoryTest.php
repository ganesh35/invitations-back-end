<?php
// tests/Repository/InviteeRepositoryTest.php
namespace App\Tests\Repository;

use App\Entity\Invitee;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class InviteeRepositoryTest extends KernelTestCase
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

    /**
     * Test: Is entityManager working? 
     */
    public function testSearchByInvitationSentTo()
    {
        $items = $this->entityManager
            ->getRepository(Invitee::class)
            ->findBy(['invitationTo' => 'ganesh35@gmail.com'])
        ;
        fwrite(STDERR, print_r($items, TRUE));
        $this->assertIsResource( $items);
    }

    /**
     * Test: Is getResultAndCount working? 
     * Test: Do we have records on the table invitatios?
     */

    public function testGetResultAndCount()
    {
        $res = $this->entityManager
            ->getRepository(Invitee::class)
            ->getResultAndCount()
        ;
        fwrite(STDERR, print_r($res, TRUE));
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

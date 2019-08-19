<?php
namespace App\Tests\Controller;
use App\Entity\Invitation;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class InvitationsControllerTest extends WebTestCase
{

    private $token;
    private $crawler;
    private $invitationTitle="Hola, Lets party tonight";
    private $rand;
    private $invitationDescription="You should feel good about making your home nicer for your family and your friends. You should feel great about cooking a good dinner and making a dress for a granddaughter, creating a beautiful birthday party. It’s all part of life.";
    private $jwt='eyJraWQiOiJxeFwvQ3FZZlBEcUY3WUxvRDNNQk1udmdYTlNJSjN4S29zMmZ1c0pqS0VlQT0iLCJhbGciOiJSUzI1NiJ9.eyJhdF9oYXNoIjoieU9nc043eTRMbFZwbkp4Q3liY0c4ZyIsInN1YiI6ImFkNzZjYTc5LTg4YjQtNDNlZS05YzIxLTRmZTQ1Yzc5N2UwOCIsImF1ZCI6IjVoMzRqcTY0bDRudnBidDE2YzhzdWY1ZTBxIiwiZW1haWxfdmVyaWZpZWQiOmZhbHNlLCJ0b2tlbl91c2UiOiJpZCIsImF1dGhfdGltZSI6MTU2NjE2OTUxMywiaXNzIjoiaHR0cHM6XC9cL2NvZ25pdG8taWRwLmV1LWNlbnRyYWwtMS5hbWF6b25hd3MuY29tXC9ldS1jZW50cmFsLTFfem1pbnJZa1J5IiwibmFtZSI6IlN0ZXZlIiwiY29nbml0bzp1c2VybmFtZSI6ImFkNzZjYTc5LTg4YjQtNDNlZS05YzIxLTRmZTQ1Yzc5N2UwOCIsImV4cCI6MTU2NjE3MzExMywiaWF0IjoxNTY2MTY5NTEzLCJlbWFpbCI6InN0ZXZlQGNvbWNhc3QubmV0In0.RpJ6m2Z6X2rMc5sqMx3VBxgruvTiYWcuz7-5K9Va0e8NnbUMx7a1W2xIc_mhTAQ4qCK6vHdqcJPF5m5fub3ixUVe_lpR6qLDLzQqecAij1v4Qo7KGWzTotoPvuC5VGi3sjZw1CPBzNbp_zcbYjW83lcwH9Iza4W5YDJrreu0m9J69mEQ3LzbUT9B1N7L2agzKyVc1dyABM-k86tu7fyuYrHzUIkYNvUgn597z-vP_Roikks155bt5cXUsB3lsnIermskgQNoaJENKMDuzLDKOgRf_eLT_R6W1qW5IWM3IaKweLwHnr9e9DgFKR4CTLduzIdVI6YCQ4OiMgHPu21--g';

    /**
     * @var \Doctrine\ORM\EntityManager
     */
    private $entityManager;

    /**
     * {@inheritDoc}
     */
    protected function setUp()
    {
        $this->crawler = static::createClient();
        $this->crawler->setServerParameter('HTTP_AUTHORIZATION', sprintf('bearer ' . $this->jwt));
        $this->crawler->setServerParameter('CONTENT_TYPE', 'application/json');
        //$this->crawler->setServerParameter('HTTP_HOST', 'localhost');
        //$this->crawler->setServerParameter('HTTP_USER_AGENT', 'Browser/1.0');

        $kernel = self::bootKernel();
        $this->entityManager = $kernel->getContainer()
            ->get('doctrine')
            ->getManager();

        $this->crawler->request('GET', '/invitations/');
        $this->token = $this->crawler->getRequest()->attributes->get('auth_token');
    }
    /**
     * {@inheritdoc}
     */
    protected function tearDown()
    {
        parent::tearDown();
        $this->crawler = null;
        $this->entityManager->close();
        $this->entityManager = null; // avoid memory leaks
    }

    public function testCheckIsLoggedUserIsSteve()
    {
        
        $this->assertEquals('steve@comcast.net', $this->token['email']);
    }

    public function testCanSteveCreateAnInvitation()
    {
        // If no errors
        $item = new Invitation();
        $item->setCreatedAt(new \DateTime());
        $item->setUpdatedAt(new \DateTime());
        $item->setTitle($this->invitationTitle);
        $item->setDescription($this->invitationDescription);

        if($this->token){
            $item->setCreatedBy($this->token['email']);
        }

        $this->entityManager->persist($item);
        $this->entityManager->flush();
        $this->assertGreaterThanOrEqual(1, $item->getId());
    }
    public function testCanSteveListHisCreatedInvitations()
    {
        $this->crawler->request('GET', '/invitations/');
        $data = json_decode($this->crawler->getResponse()->getContent(), JSON_NUMERIC_CHECK );
        $this->assertEquals(200, $this->crawler->getResponse()->getStatusCode());
        $this->assertGreaterThanOrEqual(1, count($data['items']) );
        $this->assertArrayHasKey('items', $data );
        $this->assertArrayHasKey('paginator', $data );
    }



}
 
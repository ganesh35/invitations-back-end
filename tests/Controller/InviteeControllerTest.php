<?php
namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class InviteeControllerTest extends WebTestCase
{


    private $crawler ;
    /**
     * {@inheritDoc}
     */
    protected function setUp()
    {
        $this->crawler  = static::createClient();
        $this->crawler->setServerParameter('HTTP_AUTHORIZATION', sprintf('bearer eyJraWQiOiJxeFwvQ3FZZlBEcUY3WUxvRDNNQk1udmdYTlNJSjN4S29zMmZ1c0pqS0VlQT0iLCJhbGciOiJSUzI1NiJ9.eyJhdF9oYXNoIjoieU9nc043eTRMbFZwbkp4Q3liY0c4ZyIsInN1YiI6ImFkNzZjYTc5LTg4YjQtNDNlZS05YzIxLTRmZTQ1Yzc5N2UwOCIsImF1ZCI6IjVoMzRqcTY0bDRudnBidDE2YzhzdWY1ZTBxIiwiZW1haWxfdmVyaWZpZWQiOmZhbHNlLCJ0b2tlbl91c2UiOiJpZCIsImF1dGhfdGltZSI6MTU2NjE2OTUxMywiaXNzIjoiaHR0cHM6XC9cL2NvZ25pdG8taWRwLmV1LWNlbnRyYWwtMS5hbWF6b25hd3MuY29tXC9ldS1jZW50cmFsLTFfem1pbnJZa1J5IiwibmFtZSI6IlN0ZXZlIiwiY29nbml0bzp1c2VybmFtZSI6ImFkNzZjYTc5LTg4YjQtNDNlZS05YzIxLTRmZTQ1Yzc5N2UwOCIsImV4cCI6MTU2NjE3MzExMywiaWF0IjoxNTY2MTY5NTEzLCJlbWFpbCI6InN0ZXZlQGNvbWNhc3QubmV0In0.RpJ6m2Z6X2rMc5sqMx3VBxgruvTiYWcuz7-5K9Va0e8NnbUMx7a1W2xIc_mhTAQ4qCK6vHdqcJPF5m5fub3ixUVe_lpR6qLDLzQqecAij1v4Qo7KGWzTotoPvuC5VGi3sjZw1CPBzNbp_zcbYjW83lcwH9Iza4W5YDJrreu0m9J69mEQ3LzbUT9B1N7L2agzKyVc1dyABM-k86tu7fyuYrHzUIkYNvUgn597z-vP_Roikks155bt5cXUsB3lsnIermskgQNoaJENKMDuzLDKOgRf_eLT_R6W1qW5IWM3IaKweLwHnr9e9DgFKR4CTLduzIdVI6YCQ4OiMgHPu21--g'));
        $this->crawler->setServerParameter('CONTENT_TYPE', 'application/json');
        //$this->crawler->setServerParameter('HTTP_HOST', 'localhost');
        //$this->crawler->setServerParameter('HTTP_USER_AGENT', 'Browser/1.0');
    }
    /**
     * {@inheritdoc}
     */
    protected function tearDown()
    {
        $this->crawler = null;
    }



    /*
    * Page should respond with http Status 402
    */
    
    public function testList()
    {
        $this->crawler->request('GET', '/invitees/2');
        $data = json_decode($this->crawler->getResponse()->getContent(), JSON_NUMERIC_CHECK );
        //fwrite(STDERR, print_r($data, TRUE));
        //$this->expectOutputString('foo');
        $this->assertEquals(200, $this->crawler->getResponse()->getStatusCode());
        
    }
 

}
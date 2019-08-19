<?php
namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class HomeControllerTest extends WebTestCase
{
    /*
	* Page should respond with http Status 403
	*/
    public function testIndex()
    {
		$crawler = static::createClient();
        $crawler->request('GET', '/');
        $data = json_decode($crawler->getResponse()->getContent(), true);
        $this->assertEquals(403, $crawler->getResponse()->getStatusCode());
        $this->assertEquals("Restricted access", $data['message']);
    }
}

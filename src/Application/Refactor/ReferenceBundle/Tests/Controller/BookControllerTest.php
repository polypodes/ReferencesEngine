<?php

namespace Application\Refactor\ReferenceBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class BookControllerTest extends WebTestCase
{
    /**
     * @dataProvider routeProvider
     */
    public function testRestrictedAccess($route)
    {
        $client = $this->createClient();

        $crawler = $client->request('GET', $route);
        $this->assertEquals(302, $client->getResponse()->getStatusCode());
        $this->assertTrue($client->getResponse()->isRedirect());
        $crawler = $client->followRedirect();
        $this->assertContains('Authentication', $client->getResponse()->getContent());
        $this->assertTrue($crawler->filter('html:contains("Authentication")')->count() > 0);


    }//end testIndex()

    public function routeProvider()
    {
        return array(
            array('/en/books'),
            array('/en/books/remove/1'),
            array('/en/books/add/'),
            array('/en/books/edit/1'),
            array('/en/pdf/book/1'),
            array('/en/get/pdf/book/1'),
            //array('/api/get/books/1.json'),
            //array('/api/get/books.json'),
        );
    }

    public function test404()
    {
        $client = $this->createClient();

        $client->request('GET', '/books/foo');
        $this->assertEquals(404, $client->getResponse()->getStatusCode());
    }

}//end class

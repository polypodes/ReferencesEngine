<?php

namespace Application\Refactor\ReferenceBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class FicheControllerTest extends WebTestCase
{
    /**
     * @dataProvider routeProvider
     */
    public function testRestrictedAccess($route)
    {
        $client = static::createClient();

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
            array('/en/projects'),
            array('/en/projects/remove/1'),
            array('/en/projects/add/'),
            array('/en/projects/show/1'),
            array('/en/projects/edit/1'),
            array('/en/pdf/project/1'),
            array('/en/get/pdf/project/1'),
        );
    }

    public function test404()
    {
        $client = $this->createClient();

        $client->request('GET', '/projects/foo');
        $this->assertEquals(404, $client->getResponse()->getStatusCode());
    }

}//end class

<?php
/**
 * Basic test functions
 *
 */

namespace Application\Refactor\ReferenceBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class BaseWebTest extends WebTestCase
{
    protected $client = null;
    protected $crawler = null;
    protected $login;
    protected $password;

    public function testTestUser()
    {
        $client = $this->createClient();
        $testUser = $client->getContainer()->get('fos_user.user_manager')->findUserByUsername('test');
        $this->assertTrue(!empty($testUser));
    }

    /**
     * logIn
     *
     * @return return array($crawler, $client);
     */
    protected function postLogIn()
    {
        $client = $this->createClient();
        $crawler = $client->request('GET', '/login');
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertEquals(1, $crawler->filter('input[type="submit"]')->count());
        $form = $crawler->filter('input[type="submit"]')->form();
        $crawler = $client->submit($form, array(
            '_username' => 'test',
            '_password' => 'test'
        ));
        $this->assertTrue($client->getResponse()->isRedirect());
        $crawler = $client->followRedirect();
        $this->assertTrue($this->app['security']->isGranted('IS_AUTHENTICATED_REMEMBERED'));

        $this->client = $client;
        $this->crawler = $crawler;
    }
}

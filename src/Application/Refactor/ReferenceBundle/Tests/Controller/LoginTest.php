<?php
/**
 * Test login / logout functionalities
 */

namespace Application\Refactor\ReferenceBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class LoginTest extends BaseWebTest
{
    protected $client;
    protected $crawler;
    protected $login;
    protected $password;

    public function testLoginGet()
    {
        $this->client = $this->createClient();
        $this->crawler = $this->client->request('GET', '/login');
        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
        $this->assertContains('Username', $this->client->getResponse()->getContent());
        $this->assertContains('Password', $this->client->getResponse()->getContent());
        $this->assertEquals(1, $this->crawler->filter('form[action][method="post"]')->count());
        $this->assertEquals(1, $this->crawler->filter('input#username[type="text"]')->count());
        $this->assertEquals(1, $this->crawler->filter('input#password[type="password"]')->count());
        $this->assertEquals(1, $this->crawler->filter('input[name="_csrf_token"][type=hidden]')->count());
        $this->assertTrue($this->crawler->filter('input[type="submit"]')->count() > 0);
    }

    public function testLoginPostFail()
    {
        $this->client = $this->createClient();
        $this->crawler = $this->client->request('GET', '/login');
        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
        $this->assertTrue($this->crawler->filter('input[type="submit"]')->count() > 0);
        $form = $this->crawler->filter('input[type="submit"]')->form();
        $this->crawler = $this->client->submit($form, array(
            '_username' => "'&é(§!çà123467qsdfghjDFGHJKxcvbnVBN?",
            '_password' => "$^->ù=:;,*¨£%+/.?°098765"
        ));
        $this->assertTrue($this->client->getResponse()->isRedirect());
        $this->crawler = $this->client->followRedirect();
        //$this->assertTrue(is_null($this->client->getContainer()->get('security.context')->getToken()));
        $this->assertTrue($this->client->getContainer()->get('security.context')->isGranted('IS_AUTHENTICATED_ANONYMOUSLY'));
        $this->assertContains('Username', $this->client->getResponse()->getContent());
        $this->assertContains('Password', $this->client->getResponse()->getContent());
        $this->assertEquals(1, $this->crawler->filter('form[action][method="post"]')->count());
        $this->assertEquals(1, $this->crawler->filter('input#username[type="text"]')->count());
        $this->assertEquals(1, $this->crawler->filter('input#password[type="password"]')->count());
        $this->assertEquals(1, $this->crawler->filter('input[name="_csrf_token"][type=hidden]')->count());
        $this->assertTrue($this->crawler->filter('input[type="submit"]')->count() > 0);
    }

    public function testLoginLogoutSuccess()
    {
        $this->client = $this->createClient();
        $this->crawler = $this->client->request('GET', '/login');
        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
        $this->assertTrue($this->crawler->filter('input[type="submit"]')->count() > 0);
        $form = $this->crawler->filter('input[type="submit"]')->form();
        $this->crawler = $this->client->submit($form, array(
            '_username' => 'test',
            '_password' => 'test'
        ));
        $this->assertTrue($this->client->getResponse()->isRedirect());
        $this->crawler = $this->client->followRedirect();
        $this->assertTrue($this->client->getContainer()->get('security.context')->isGranted('IS_AUTHENTICATED_REMEMBERED'));
        $this->assertContains('Redirecting', $this->client->getResponse()->getContent());
        $this->assertTrue($this->client->getResponse()->isRedirect());
        $this->crawler = $this->client->followRedirect();
        $this->assertContains('Logout', $this->client->getResponse()->getContent());
        $link = $this->crawler->filter('a[href="/logout"]')->eq(0)->link();
        $this->crawler = $this->client->click($link);
        $this->assertTrue($this->client->getResponse()->isRedirect());
        $this->crawler = $this->client->followRedirect();
        $this->assertEquals(302, $this->client->getResponse()->getStatusCode());

    }
}

<?php
/**
 * Created by PhpStorm.
 * User: ronan
 * Date: 23/07/2014
 * Time: 15:55
 */

namespace Application\Refactor\ReferenceBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class RestAPIAuthenticationTest extends BaseWebTest
{
    protected $client;
    protected $crawler;
    protected $login;
    protected $password;

    public function testLoginGet()
    {
        $this->client = $this->createClient();
        $this->client->followRedirects();
        $payload = array("username"=>"test", "password"=>"test");
        $this->crawler = $this->client->request('POST', '/api/tokens/creates.json', $payload);
        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
        $expecteds = array('x-wsse', 'PasswordDigest', 'Nonce', 'Created');
        foreach($expecteds as $expected) {
            $this->assertContains($expected, $this->client->getResponse()->getContent());
        }
    }
}
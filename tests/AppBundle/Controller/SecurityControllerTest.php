<?php


namespace Tests\AppBundle\Controller;


use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class SecurityControllerTest extends WebTestCase
{
    public function testLogin()
    {
        $client = static::createClient();
        $client->request('POST', '/login', array(), array(), array(
            'PHP_AUTH_USER' => 'julien',
            'PHP_AUTH_PW' => 'password'
        ));

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }
}
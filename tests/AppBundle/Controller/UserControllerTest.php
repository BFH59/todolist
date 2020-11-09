<?php


namespace Tests\AppBundle\Controller;


use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class UserControllerTest extends WebTestCase
{
    public function testList()
    {
        $client = static::createClient();
        $client->request('GET', '/users');

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }
/**
    public function testCreate()
    {
        $client = static::createClient();
        $client->request('POST', '/users/create', array(), array(), array(
            'PHP_AUTH_USER' => 'julien',
            'PHP_AUTH_PW' => 'password'
        ),[
            'username' => 'test',
            'password' => 'password'
        ]);



        $this->assertTrue($client->getResponse()->isSuccessful());
    }
*/
    public function testEdit()
    {
        $client = static::createClient();
        $client->request('GET', '/users/2/edit', array(), array(), array(
            'PHP_AUTH_USER' => 'julien',
            'PHP_AUTH_PW' => 'password'
        ));



        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }

}
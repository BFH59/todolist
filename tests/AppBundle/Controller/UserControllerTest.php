<?php


namespace Tests\AppBundle\Controller;


use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class UserControllerTest extends WebTestCase
{
    public function testKOList()
    {
        $client = static::createClient();
        $client->request('GET', '/users');

        $this->assertEquals(302, $client->getResponse()->getStatusCode());
    }
//attempt to access /users with only role_user
    public function testKORoleUserList()
    {
        $client = static::createClient();
        $client->request('GET', '/users', array(), array(), array(
            'PHP_AUTH_USER' => 'bbb',
            'PHP_AUTH_PW' => 'bbb'
        ));

        $this->assertEquals(403, $client->getResponse()->getStatusCode());
    }
//access to route /users with admin role
    public function testOKList()
    {
        $client = static::createClient();
        $client->request('GET', '/users', array(), array(), array(
            'PHP_AUTH_USER' => 'admin',
            'PHP_AUTH_PW' => 'admin'
        ));

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }


    public function testCreate()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/users/create', array(), array(), array(
            'PHP_AUTH_USER' => 'admin',
            'PHP_AUTH_PW' => 'admin'
        ));

        $buttonCrawlerNode = $crawler->selectButton('Ajouter');
        $form = $buttonCrawlerNode->form();
        $client->submit($form,[
            'user[username]' => 'Test12345',
            'user[password][first]' => 'password',
            'user[password][second]' => 'password',
            'user[email]' => 'test12345@12345test.com'

        ]);




        $this->assertTrue($client->getResponse()->isRedirect());
    }
//admin acces edit page of its own account
    public function testAdminEdit()
    {
        $client = static::createClient();
        $client->request('GET', '/users/2/edit', array(), array(), array(
            'PHP_AUTH_USER' => 'admin',
            'PHP_AUTH_PW' => 'admin'
        ));



        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }

    //admin change user role to admin for user id = 3
    public function testUserRoleEdit()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/users/3/edit', array(), array(), array(
            'PHP_AUTH_USER' => 'admin',
            'PHP_AUTH_PW' => 'admin'
        ));



        $buttonCrawlerNode = $crawler->selectButton('Modifier');
        $form = $buttonCrawlerNode->form();
        $client->submit($form,[
            'user[username]' => 'TestEdition',
            'user[email]' => 'test12345@12345test.com',
            'user[roles]' => 'ROLE_ADMIN'

        ]);




        $this->assertTrue($client->getResponse()->isRedirect());
    }

    //user editing its own profile
    public function testUserOKEdit()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/users/8/edit', array(), array(), array(
            'PHP_AUTH_USER' => 'bbb',
            'PHP_AUTH_PW' => 'bbb'
        ));



        $buttonCrawlerNode = $crawler->selectButton('Modifier');
        $form = $buttonCrawlerNode->form();
        $client->submit($form,[
            'user[username]' => 'bbb_edit',
            'user[email]' => 'bbb@bb.com',
            'user[password][first]' => 'bbb',
            'user[password][second]' => 'bbb',

        ]);




        $this->assertTrue($client->getResponse()->isRedirect());
    }

}
<?php


namespace Tests\AppBundle\Controller;


use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class TaskControllerTest extends WebTestCase
{
    //access to tasks list when logged in as normal user (role_user)
    public function testList()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/tasks', array(), array(), array(
            'PHP_AUTH_USER' => 'bbb',
            'PHP_AUTH_PW' => 'bbb'
        ));

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertEquals(7, $crawler->filter('div.caption')->count());
    }

    //create new task by user
    public function testnewTaskCreate()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/tasks/create', array(), array(), array(
            'PHP_AUTH_USER' => 'bbb',
            'PHP_AUTH_PW' => 'bbb'
        ));

        $buttonCrawlerNode = $crawler->selectButton('Ajouter');
        $form = $buttonCrawlerNode->form();
        $client->submit($form,[
            'task[title]' => 'tache test',
            'task[content]' => 'tache test'

        ]);




        $this->assertTrue($client->getResponse()->isRedirect());
    }

    //edit task by user
    public function testTaskEdit()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/tasks/2/edit', array(), array(), array(
            'PHP_AUTH_USER' => 'bbb',
            'PHP_AUTH_PW' => 'bbb'
        ));

        $buttonCrawlerNode = $crawler->selectButton('Modifier');
        $form = $buttonCrawlerNode->form();
        $client->submit($form,[
            'task[title]' => 'tache test',
            'task[content]' => 'tache test'

        ]);




        $this->assertTrue($client->getResponse()->isRedirect());
    }

    //user toggle task as done
    public function testToggleTask()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/tasks', array(), array(), array(
            'PHP_AUTH_USER' => 'bbb',
            'PHP_AUTH_PW' => 'bbb'
        ));

        $buttonCrawlerNode = $crawler->selectButton('Marquer comme faite')->eq(0);
        $form = $buttonCrawlerNode->form();
        $client->submit($form);




        $this->assertTrue($client->getResponse()->isRedirect());
    }

    //user try to delete anonymous task // not allowed
    public function testKODeleteTask()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/tasks', array(), array(), array(
            'PHP_AUTH_USER' => 'bbb',
            'PHP_AUTH_PW' => 'bbb'
        ));

        $buttonCrawlerNode = $crawler->selectButton('Supprimer')->eq(0);
        $form = $buttonCrawlerNode->form();
        $client->submit($form);




        $this->assertEquals(403, $client->getResponse()->getStatusCode());
    }

    //user delete its own task // OK
    public function testuserOKDeleteTask()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/tasks', array(), array(), array(
            'PHP_AUTH_USER' => 'bbb',
            'PHP_AUTH_PW' => 'bbb'
        ));

        $buttonCrawlerNode = $crawler->selectButton('Supprimer')->eq(6);
        $form = $buttonCrawlerNode->form();
        $client->submit($form);




        $this->assertTrue($client->getResponse()->isRedirect());
    }
//admin delete anonymous task // OK
    public function testOKadminDeleteTask()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/tasks', array(), array(), array(
            'PHP_AUTH_USER' => 'admin',
            'PHP_AUTH_PW' => 'admin'
        ));

        $buttonCrawlerNode = $crawler->selectButton('Supprimer')->eq(0);
        $form = $buttonCrawlerNode->form();
        $client->submit($form);




        $this->assertTrue($client->getResponse()->isRedirect());
    }

    public function testuserNotConnectedDeleteTask()
    {
        $client = static::createClient();
        $client->request('POST', '/tasks/3/delete');


$this->assertResponseRedirects(null,302);
    }
}
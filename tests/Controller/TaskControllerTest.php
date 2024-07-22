<?php 

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

class TaskControllerTest extends WebTestCase
{
    private $client;


    public function setUp(): void
    {
        $this->client = static::createClient();
        $crawler = $this->client->request('GET', '/login');
        $form = $crawler->selectButton('Se connecter')->form();
        $this->client->submit($form, ['_username' => 'test@example.com', '_password' => 'password']);
    }

    public function testListAction(): void
    {
        $this->client->request('GET', "/tasks/");
        // dd($this->client->getResponse());
        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
    }

    public function testCreateAction()
    {
        $crawler = $this->client->request('GET', "/tasks/create");
        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());

        $form = $crawler->selectButton('Ajouter')->form([
            'task[title]' => 'Title test',
            'task[content]' => 'Content test',
        ]);

        $this->client->submit($form);
        $this->assertEquals(302, $this->client->getResponse()->getStatusCode());

        $this->assertResponseRedirects('/tasks/');
        $this->client->followRedirect();

        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
        $this->assertSelectorTextContains('div.alert-success', 'La tâche a été bien été ajoutée.');

    }

    public function testEditAction()
    {
        $crawler = $this->client->request('GET', '/tasks/7/edit');
        $this->assertResponseStatusCodeSame(Response::HTTP_OK);

        $form = $crawler->selectButton('Modifier')->form([
            'task[title]' => 'Edit Task Title',
            'task[content]' => 'Edit task content',
        ]);

        $this->client->submit($form);
        $this->assertEquals(302, $this->client->getResponse()->getStatusCode());


        $this->assertResponseRedirects('/tasks/');
        $this->client->followRedirect();

        $this->assertResponseStatusCodeSame(Response::HTTP_OK);
        $this->assertSelectorTextContains('div.alert-success', 'Superbe ! La tâche a bien été modifiée.');

    }

    public function testToggleTaskAction()
    {
        $this->client->request('GET', '/tasks/7/toggle');
        $this->assertEquals(302, $this->client->getResponse()->getStatusCode());

        $this->assertResponseRedirects('/tasks/');

        $crawler = $this->client->followRedirect();

        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
        $this->assertEquals(1, $crawler->filter('div.alert-success')->count());
    }

    public function testDeleteTaskAction()
    {
        $this->client->request('GET', '/tasks/7/delete');

        $this->assertEquals(302, $this->client->getResponse()->getStatusCode());

        $this->assertResponseRedirects('/tasks/');
        $this->client->followRedirect();

        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
        $this->assertSelectorTextContains('div.alert-success', 'La tâche a bien été supprimée.');
    }

    public function testGetValidatedTask()
    {
        $this->client->request('GET', '/tasks/completed');

        $this->assertResponseStatusCodeSame(Response::HTTP_OK);
    }

    public function testListExpiredTask(): void
    {
        $this->client->request('GET', "/tasks/expired");
        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
    }
}
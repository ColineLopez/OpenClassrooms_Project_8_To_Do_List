<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

class UserControllerTest extends WebTestCase
{
	private $client;

	public function setUp(): void 
	{
		$this->client = static::createClient();
		$crawler = $this->client->request('GET', '/login');
		$form = $crawler->selectButton('Se connecter')->form();
		$this->client->submit($form, ['_username' => 'admin@example.com', '_password' => 'admin']);
	}

	public function testListAction(): void 
	{
		$this->client->request('GET', "/users/");
		$this->assertEquals(200, $this->client->getResponse()->getStatusCode());
	}

	public function testCreateAction(): void 
	{
		$crawler = $this->client->request('GET', '/users/create');
		$this->assertEquals(200, $this->client->getResponse()->getStatusCode());


		//  CHECK LE CONTENU TEXTE DU BOUTON + LES CHAMPS & NOMS DES CHAMPS DU FORMULAIRE
		$form = $crawler->selectButton('Ajouter')->form([
			'user[username]' => 'Username test',
			'user[password][first]' => 'testPassword',
			'user[password][second]' => 'testPassword',
			'user[email]' => 'user_email@test.com',
			// 'user[roles][0]'->tick()
		]);

		$this->client->submit($form);
		$this->assertEquals(302, $this->client->getResponse()->getStatusCode());


		$this->assertResponseRedirects('/users/');
		$this->client->followRedirect();

		$this->assertEquals(200, $this->client->getResponse()->getStatusCode());
		$this->assertSelectorTextContains('div.alert-success', "L'utilisateur a bien été ajouté.");
	}

	public function testEditAction(): void 
	{
		$crawler = $this->client->request('GET', '/users/9/edit');
		$this->assertEquals(200, $this->client->getResponse()->getStatusCode());

		$form = $crawler->selectButton('Modifier')->form([
			'user[username]' => 'Username edit test',
			'user[password][first]' => 'testEditPassword',
			'user[password][second]' => 'testEditPassword',
			'user[email]' => 'user_email_edit@test.com',
			// 'user[roles][0]'->tick()
		]);

		$this->client->submit($form);
		$this->assertEquals(302, $this->client->getResponse()->getStatusCode());

		$this->assertResponseRedirects('/users/');
		$this->client->followRedirect();

		$this->assertEquals(200, $this->client->getResponse()->getStatusCode());
		$this->assertSelectorTextContains('div.alert-success', "Superbe ! L'utilisateur a bien été modifié.");

		// $this->assertEquals(1, $crawler->filter('div.alert-success')->count());
	}

}
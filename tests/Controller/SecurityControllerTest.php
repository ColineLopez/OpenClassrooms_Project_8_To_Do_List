<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class SecurityControllerTest extends WebTestCase
{
	private $client;

	public function setUp(): void 
	{
		$this->client = static::createClient();
	}

	public function loginUser(): void
    {
        $crawler = $this->client->request('GET', '/login');
        $form = $crawler->selectButton('Connexion')->form();
        $this->client->submit($form, ['_username' => 'test@example.com', '_password' => 'password']);
    }

	public function testLoginUser(): void
    {
        $crawler = $this->client->request('GET', '/login');
        $form = $crawler->selectButton('Se connecter')->form();
        $this->client->submit($form, ['_username' => 'test@example.com', '_password' => 'password']);
        $this->assertEquals(302, $this->client->getResponse()->getStatusCode());
    }
}
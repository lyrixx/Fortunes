<?php

namespace Tests\AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class DefaultControllerTest extends WebTestCase
{
    public function testIndex()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/');

        $this->assertSame(200, $client->getResponse()->getStatusCode());
    }

    public function testNew()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/new');

        $this->assertSame(200, $client->getResponse()->getStatusCode());

        $form = $crawler->selectButton('Save')->form();
        $crawler = $client->submit($form, ['fortune' => [
            'quotes' => '<greg> hello',
        ]]);

        $this->assertSame(302, $client->getResponse()->getStatusCode());
    }
}

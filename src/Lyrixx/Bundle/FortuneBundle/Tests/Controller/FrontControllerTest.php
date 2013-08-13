<?php

namespace Lyrixx\Bundle\FortuneBundle\Tests\Controller;

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
    }
}

<?php

namespace Tests\AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class DefaultControllerTest extends WebTestCase
{
    public function testIndex()
    {
        $client = static::createClient();
        $client->followRedirects(true);

        $client->request('GET', '/');
        $this->assertEquals(200, $client->getResponse()->getStatusCode());

        $client->request('GET', '/admin/app/treasuretype/list');
        $this->assertEquals(200, $client->getResponse()->getStatusCode());

        $client->request('GET', '/admin/app/treasuretype/create');
        $this->assertEquals(200, $client->getResponse()->getStatusCode());

        $client->request('GET', '/admin/app/transaction/list');
        $this->assertEquals(200, $client->getResponse()->getStatusCode());

        $client->request('GET', '/admin/app/transaction/create');
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }
}

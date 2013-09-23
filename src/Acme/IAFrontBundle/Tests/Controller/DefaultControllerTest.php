<?php

namespace Acme\IAFrontBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class DefaultControllerTest extends WebTestCase
{
    public function testHomepage()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/');

        $this->assertTrue($crawler->filter('html:contains("CHAT AVEC I.A")')->count() > 0);
    }
}

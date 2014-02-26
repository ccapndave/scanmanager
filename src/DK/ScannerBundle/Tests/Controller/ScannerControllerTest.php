<?php

namespace DK\ScannerBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ScannerControllerTest extends WebTestCase {

    public function testStatus() {
        $client = static::createClient();

        $crawler = $client->request('GET', '/status');
    }

}

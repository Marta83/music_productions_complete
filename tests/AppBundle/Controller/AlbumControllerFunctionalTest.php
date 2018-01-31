<?php

namespace Tests\AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class AlbumControllerFunctionalTest extends WebTestCase
{

    private $client;

    protected function setUp()
    {
        $this->client = static::createClient();
    }

    public function testAddAlbumRoute()
    {
        $this->client->request('GET',"/add-album");

        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
    }

    public function testAddAlbum()
    {
        $crawler = $this->client->request('GET',"/add-album");

        $form = $crawler->selectButton('Create')->form();
        $form['album[title]'] = 'Album title';

        $crawler = $this->client->submit($form);

        $this->assertTrue($this->client->getResponse()->isRedirect());
    }


}

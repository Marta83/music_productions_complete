<?php

namespace Tests\AppBundle\Controller;

use Tests\DataFixturesTestCase;

class ArtistControllerFunctionalTest extends DataFixturesTestCase
{

    protected function setUp()
    {
        parent::setUp();
        parent::populateData();
    }

    public function testAddAlbum()
    {
        $crawler = $this->client->request('GET', "/add-artist/{$this->albums[0]->getId()}");

        $form = $crawler->selectButton('Create')->form();
        $form['artist[name]'] = 'Artist name new';
        $form['artist[speciality]'] = 'Artist specialty';

        $crawler = $this->client->submit($form);

        $this->assertTrue($this->client->getResponse()->isRedirect('/'));

        $this->client->followRedirect();
        $this->assertContains('Artist name new', $this->client->getResponse()->getContent());
    }



}

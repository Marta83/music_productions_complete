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

    public function testDeleteArtist()
    {
        $crawler = $this->client->request('GET',"/");
        $album = $this->albums[0];
        $artist = $this->albums[0]->getArtists()[0];

        $link = $crawler
            ->filter("#delete-artist-{$album->getId()}-{$artist->getId()}")
            ->link()
            ;

        $crawler = $this->client->click($link);
        $this->assertTrue($this->client->getResponse()->isRedirect());
        $this->client->followRedirect();
        $this->assertNotContains($artist->getName(), $this->client->getResponse()->getContent());

    }


}

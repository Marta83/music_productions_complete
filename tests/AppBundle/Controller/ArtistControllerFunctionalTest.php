<?php

namespace Tests\AppBundle\Controller;

use Tests\DataFixturesTestCase;
use AppBundle\Entity\Album;

class ArtistControllerFunctionalTest extends DataFixturesTestCase
{

    protected function setUp()
    {
        parent::setUp();
        parent::populateData();
    }

    public function testAddAlbum()
    {
        $crawler = $this->client->request('GET',"/");
        $album = array_shift($this->albums);
        $num_artist = count($album->getArtists());

        //get assing Link
        $link = $crawler->filter(".assign-artist")
                        ->eq(0)->link();
        $crawler = $this->client->click($link);

        //get add Link
        $link = $crawler->filter(".add-artist")
                        ->link();
        $crawler = $this->client->click($link);

        //get form and submit
        $form = $crawler->selectButton('Create')->form();
        $form['artist[name]'] = 'Artist name new';
        $form['artist[speciality]'] = 'Artist specialty';

        $crawler = $this->client->submit($form);
        $this->client->followRedirect();
        $album = $this->em->getRepository(Album::class)->find($album->getId());

        //assert assign new artist
        $this->assertEquals($num_artist +1, count($album->getArtists()));
        $this->assertContains('Artist name new', $this->client->getResponse()->getContent());
    }

    public function testDeleteArtist()
    {
        $crawler = $this->client->request('GET',"/");
        $album = $this->albums[0];
        $artist = $this->albums[0]->getArtists()[0];

        //get delete link and clic
        $link = $crawler
            ->filter("#delete-artist-{$album->getId()}-{$artist->getId()}")
            ->link()
            ;
        $crawler = $this->client->click($link);
        $this->client->followRedirect();

        //assert artist deleted
        $this->assertNotContains($artist->getName(), $this->client->getResponse()->getContent());

    }


}

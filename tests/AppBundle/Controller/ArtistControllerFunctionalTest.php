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

    public function testAddArtistError()
    {
        $crawler = $this->client->request('GET',"/");
        $album = array_shift($this->albums);
        $num_artist = count($album->getContributions());

        //get assing Link
        $link = $crawler->filter(".add-artist")
                        ->eq(0)->link();
        $crawler = $this->client->click($link);

        //get form and submit
        $form = $crawler->selectButton('Create')->form();
        $form['artist[name]'] = 'Artist name new';
        $form['artist[speciality]'] = 'Artist specialty';
        $form['artist[fee]'] = "not a number";

        $crawler = $this->client->submit($form);

        //assert error fee
        $this->assertFalse($this->client->getResponse()->isRedirect());
        $this->assertContains('This value is not valid', $this->client->getResponse()->getContent());
    }

    public function testAddArtist()
    {
        $crawler = $this->client->request('GET',"/");
        $album = array_shift($this->albums);
        $num_artist = count($album->getContributions());

        //get assing Link
        $link = $crawler->filter(".add-artist")
                        ->eq(0)->link();
        $crawler = $this->client->click($link);

        //get form and submit
        $form = $crawler->selectButton('Create')->form();
        $form['artist[name]'] = 'Artist name new';
        $form['artist[speciality]'] = 'Artist specialty';
        $form['artist[fee]'] = rand(1,3000);

        $crawler = $this->client->submit($form);
        $this->client->followRedirect();
        $album = $this->em->getRepository(Album::class)->find($album->getId());

        //assert assign new artist
        $this->assertEquals($num_artist +1, count($album->getContributions()));
        $this->assertContains('Artist name new', $this->client->getResponse()->getContent());
    }

    public function testDeleteArtist()
    {
        $crawler = $this->client->request('GET',"/");
        $album = $this->albums[0];
        $contribution = $this->albums[0]->getContributions()->first();
        $artist = $contribution->getArtist();

        //get delete link and clic
        $link = $crawler
            ->filter("#delete-artist-{$contribution->getId()}")
            ->link()
            ;
        $crawler = $this->client->click($link);
        $this->client->followRedirect();

        //assert artist deleted
        $this->assertNotContains($artist->getName(), $this->client->getResponse()->getContent());

    }


}

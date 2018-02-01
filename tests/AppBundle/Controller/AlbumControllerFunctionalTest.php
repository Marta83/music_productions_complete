<?php

namespace Tests\AppBundle\Controller;

use Tests\DataFixturesTestCase;
use AppBundle\Entity\Artist;

class AlbumControllerFunctionalTest extends DataFixturesTestCase
{

    protected function setUp()
    {
        parent::setUp();
        parent::populateData();
    }

    /**
     * @dataProvider urlProvider
     */
    public function testPageIsSuccessful($url)
    {
        $this->client->request('GET', $url);

        $this->assertTrue($this->client->getResponse()->isSuccessful());
    }

    public function urlProvider()
    {
        return array(
            array('/'),
            array('/add-album'),
        );
    }

    public function testAddAlbum()
    {
        $crawler = $this->client->request('GET',"/add-album");

        //get and submit form
        $form = $crawler->selectButton('Create')->form();
        $form['album[title]'] = 'Album title new';

        $crawler = $this->client->submit($form);

        $this->assertTrue($this->client->getResponse()->isRedirect('/'));
        $this->client->followRedirect();

        $this->assertContains('Album title new', $this->client->getResponse()->getContent());
    }

    public function testlistsAlbums()
    {
        $crawler = $this->client->request('GET',"/");
        $content = $this->client->getResponse()->getContent();

        //assert add-album link is pressent
        $node = $crawler->filterXPath('//a[@id="add-album"]');
        $this->assertTrue($node->count() == 1);

        //assert list of albums an artists
        foreach($this->albums as $album){
          $this->assertContains($album->getTitle(), $content);
        }

        foreach($this->artists as $artist){
          $this->assertContains($artist->getName(), $content);
        }
    }

    public function testAssingArtistToAlbum()
    {
        $crawler = $this->client->request('GET',"/");
        $artist = array_pop($this->artists);
        $num_albums = count($artist->getAlbums());

        //get assing Link
        $link = $crawler->filter(".assign-artist")
                        ->eq(0)->link();

        $crawler = $this->client->click($link);

        //assert add-artist link is pressent
        $node = $crawler->filterXPath('//a[@class="add-artist"]');
        $this->assertTrue($node->count() == 1);

        //Select artist
        $value = $crawler->filter("option:contains('{$artist->getTitle()}')")->attr('value');
        $form = $crawler->selectButton('Assign')->form();
        $form['existed_artist[artists]']->select($value);

        $crawler = $this->client->submit($form);
        $this->client->followRedirect();
        $artist = $this->em->getRepository(Artist::class)->find($artist->getId());

        //assert assign existed artist
        $this->assertEquals($num_albums +1, count($artist->getAlbums()));
    }


    public function testDeleteAlbum()
    {
        $crawler = $this->client->request('GET',"/");

        //get delete link and clic
        $link = $crawler
            ->filter("#delete-album-{$this->albums[0]->getId()}")
            ->link()
            ;
        $crawler = $this->client->click($link);

        //assert album deleted
        $this->assertTrue($this->client->getResponse()->isRedirect());

    }


}

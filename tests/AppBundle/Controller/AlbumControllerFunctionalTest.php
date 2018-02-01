<?php

namespace Tests\AppBundle\Controller;

use Tests\DataFixturesTestCase;

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

        foreach($this->albums as $album){
          $this->assertContains($album->getTitle(), $content);
        }
    }

    public function testDeleteAlbum()
    {
        $crawler = $this->client->request('GET',"/");

        $link = $crawler
            ->filter('a:contains("Delete")')
            ->eq(1)
            ->link()
            ;

        $crawler = $this->client->click($link);
        $this->assertTrue($this->client->getResponse()->isRedirect());


    }


}

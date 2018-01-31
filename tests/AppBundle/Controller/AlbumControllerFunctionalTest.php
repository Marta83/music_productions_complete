<?php

namespace Tests\AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Doctrine\Common\DataFixtures\Loader;
use AppBundle\DataFixtures\AlbumFixtures;
use Doctrine\Common\DataFixtures\Executor\ORMExecutor;
use Doctrine\Common\DataFixtures\Purger\ORMPurger;

class AlbumControllerFunctionalTest extends WebTestCase
{

    private $client;

    protected function setUp()
    {
        $this->client = static::createClient();
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
        $form['album[title]'] = 'Album title';

        $crawler = $this->client->submit($form);

        $this->assertTrue($this->client->getResponse()->isRedirect('/'));
    }

    public function testlistsAlbums()
    {
        $crawler = $this->client->request('GET',"/");

        $this->assertEquals(1,$crawler->filter('html:contains("Album title")')->count());
    }

    public function testDeleteAlbum()
    {
        $crawler = $this->client->request('GET',"/");

        $this->assertEquals(1,$crawler->filter('html:contains("Album title")')->count());

        $link = $crawler
            ->filter('a:contains("Delete")')
            ->eq(1)
            ->link()
            ;

        $crawler = $this->client->click($link);
        $this->assertTrue($this->client->getResponse()->isRedirect());


    }


}

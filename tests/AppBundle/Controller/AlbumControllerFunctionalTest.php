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

        $this->populateData();
    }

    private function populateData()
    {
        $loader = new Loader();
        $purger = new ORMPurger();
        $em= $this->client->getContainer()->get('doctrine.orm.entity_manager');;

        $loader->loadFromFile('src/AppBundle/DataFixtures/AlbumFixtures.php');

        $executor = new ORMExecutor($em, $purger);
        $executor->execute($loader->getFixtures());
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

        $this->assertEquals(20,$crawler->filter('.album')->count());
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

<?php

namespace Tests\AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Doctrine\Common\DataFixtures\Loader;
use Doctrine\Common\DataFixtures\Executor\ORMExecutor;
use Doctrine\Common\DataFixtures\Purger\ORMPurger;
use AppBundle\DataFixtures\AlbumFixtures;
use AppBundle\Entity\Album;
use AppBundle\Entity\Artist;

class ArtistControllerFunctionalTest extends WebTestCase
{

    private $client;
    private $albums;
    private $artist;

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

        $this->albums = $em->getRepository(Album::class)->findAll();
        $this->artist = $em->getRepository(Artist::class)->findAll();

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

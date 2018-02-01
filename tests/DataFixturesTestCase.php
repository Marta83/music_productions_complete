<?php

namespace Tests;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Doctrine\Common\DataFixtures\Loader;
use Doctrine\Common\DataFixtures\Executor\ORMExecutor;
use Doctrine\Common\DataFixtures\Purger\ORMPurger;
use AppBundle\DataFixtures\AlbumFixtures;
use AppBundle\Entity\Album;
use AppBundle\Entity\Artist;


class DataFixturesTestCase extends WebTestCase
{
    protected $client;
    protected $container;
    protected $entityManager;
    protected $albums;
    protected $artist;

    protected function setUp()
    {
        $this->client = static::createClient();
        $this->container = $this->client->getContainer();
        $this->em = $this->container->get('doctrine.orm.entity_manager');

        parent::setUp();
    }

    protected function populateData()
    {
        $loader = new Loader();
        $purger = new ORMPurger();

        $loader->loadFromFile('src/AppBundle/DataFixtures/AlbumFixtures.php');

        $executor = new ORMExecutor($this->em, $purger);
        $executor->execute($loader->getFixtures());

        $this->albums = $this->em->getRepository(Album::class)->findAll();
        $this->artist = $this->em->getRepository(Artist::class)->findAll();

    }

    public function tearDown()
    {
        parent::tearDown();
    }


}


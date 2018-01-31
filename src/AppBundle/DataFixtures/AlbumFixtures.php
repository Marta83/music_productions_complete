<?php

namespace AppBundle\DataFixtures;

use App\Entity\Product;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use AppBundle\Entity\Album;

class AlbumFixtures implements FixtureInterface
{
    public function load(ObjectManager $manager)
    {
            for ($i = 0; $i < 20; $i++) {
                $album = new Album();
                $album->setTitle('Album title');
                $album->setPublishedAt(new \DateTime());
                $manager->persist($album);
            }

        $manager->flush();
    }
}

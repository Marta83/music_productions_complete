<?php

namespace AppBundle\DataFixtures;

use App\Entity\Product;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\Persistence\ObjectManager;
use AppBundle\Entity\Album;
use AppBundle\Entity\Artist;

class AlbumFixtures extends AbstractFixture
{
    public function load(ObjectManager $manager)
    {
            for ($i = 0; $i < 5; $i++) {
                $album = new Album();
                $album->setTitle('Album title ' . $i);
                $album->setPublishedAt(new \DateTime());
                $manager->persist($album);

                $this->addReference("album-$i", $album);
            }

        $manager->flush();
    }
}

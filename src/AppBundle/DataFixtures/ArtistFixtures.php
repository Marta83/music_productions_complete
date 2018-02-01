<?php

namespace AppBundle\DataFixtures;

use App\Entity\Product;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\Persistence\ObjectManager;
use AppBundle\Entity\Artist;

class ArtistFixtures extends AbstractFixture
{
    public function load(ObjectManager $manager)
    {
        $this->addArtistPerAlbum($manager);
        $this->addArtistPerAlbum($manager);
        $this->addArtistPerAlbum($manager);
    }

    private function addArtistPerAlbum(ObjectManager $manager): void
    {
        for ($i = 0; $i < 5; $i++) {

            $artist = new Artist();
            $artist->setName('Artist name ' . $i);
            $artist->setSpeciality('Artist speciality ' .$i);
            $artist->addAlbum($this->getReference("album-$i"));
            $manager->persist($artist);

        }

        $manager->flush();
    }
}

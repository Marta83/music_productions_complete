<?php

namespace AppBundle\DataFixtures;

use App\Entity\Product;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\Persistence\ObjectManager;
use AppBundle\Entity\Contribution;
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
            $album =$this->getReference("album-$i");
            $number = $i + rand(1,1000) + $album->getId();

            $artist = new Artist();
            $artist->setName('Artist name ' . $number);
            $artist->setSpeciality('Artist speciality ' .$number);
            $manager->persist($artist);

            $contribution = new Contribution();
            $contribution->setAlbum($album);
            $contribution->setArtist($artist);
            $contribution->setFee(rand(1,5000));
            $manager->persist($contribution);

        }

        $manager->flush();
    }
}

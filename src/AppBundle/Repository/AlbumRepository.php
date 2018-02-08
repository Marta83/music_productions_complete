<?php

namespace AppBundle\Repository;

use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use AppBundle\Repository\AlbumRepositoryInterface;
use AppBundle\Entity\Album;

class AlbumRepository extends ServiceEntityRepository implements AlbumRepositoryInterface
{
    public function __construct(RegistryInterface $registry)

    {
        parent::__construct($registry, Album::class);
    }

    public function save(Album $album)
    {
        $this->_em->persist($album);
        $this->_em->flush();
    }

}

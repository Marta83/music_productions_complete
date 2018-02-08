<?php

namespace AppBundle\Repository;

use AppBundle\Entity\Album;

interface AlbumRepositoryInterface
{
    public function save(Album $album);
}

<?php

namespace AppBundle\Command\Handler;

use AppBundle\Command\CreateAlbumCommand;
use AppBundle\Repository\AlbumRepositoryInterface;
use AppBundle\Entity\Album;

class CreateAlbumHandler
{
    /**
     * @var AlbumRepositoryInterface
     */

    private $repository;

    /**
     * CreateAlbumHandler constructor.
     * @param AlbumRepositoryInterface $repository
     */

    public function __construct(AlbumRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @param CreateAlbumCommand $command
     */
    public function handle(CreateAlbumCommand $command)
    {
        $album = new Album($command->getTitle(), $command->getPublishedAt());
        $this->repository->save($album);
    }
}

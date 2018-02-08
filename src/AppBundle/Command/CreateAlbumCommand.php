<?php
namespace AppBundle\Command;

use SimpleBus\Message\Name\NamedMessage;

class CreateAlbumCommand implements NamedMessage
{
    /**
     * @var string
     */
    private $title;

    /**
     * @var datetime
     */
    private $published_at;



    /**
     * CreateAlbumCommand constructor.
     * @param string $title,
     * @param datetime $published_at,
     */
    public function __construct(string $title, \DateTime $published_at)
    {
        $this->title = $title;
        $this->published_at = $published_at;
    }

    /**
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @return datetime
     */
    public function getPublishedAt()
    {
        return $this->published_at;
    }

    /**
     * The name of this particular type of message.
     *
     * @return string
     */
    public static function messageName()
    {
        return 'create_album_command';
    }
}

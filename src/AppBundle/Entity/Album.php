<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Album
 *
 * @ORM\Table(name="album")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\AlbumRepository")
 */
class Album
{

    public function __construct(string $title, \DateTime $published_at) {
        $this->contributions = new \Doctrine\Common\Collections\ArrayCollection();

        $this->title = $title;
        $this->published_at = $published_at;
    }

    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="title", type="string", length=255)
     */
    private $title;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="published_at", type="datetime")
     */
    private $published_at;

    /**
     * @ORM\OneToMany(targetEntity="Contribution", mappedBy="album", cascade={"remove"})
     * @ORM\JoinTable(name="contribution")
     */
    private $contributions;


    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Get Contributions
     *
     * @return contributions
     */
    public function getContributions()
    {
        return $this->contributions;
    }

    /**
     * Add Contribution
     *
     */
    public function addContribution(Contribution $contribution)
    {
        $this->contributions[] = $contribution;
    }


    /**
     * Get title
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Get published_at
     *
     * @return \DateTime
     */
    public function getPublishedAt()
    {
        return $this->published_at;
    }
}


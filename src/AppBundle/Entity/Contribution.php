<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Contribution
 *
 * @ORM\Table(name="contribution")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ContributionRepository")
 */
class Contribution
{

    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var float
     *
     * @ORM\Column(name="fee", type="float")
     */
    private $fee;

    /**
     * @ORM\ManyToOne(targetEntity="Artist", inversedBy="contributions", cascade={"remove"})
     * @ORM\JoinColumn(name="artist_id", referencedColumnName="id", nullable=false)
     */
    protected $artist;

    /**
     * @ORM\ManyToOne(targetEntity="Album", inversedBy="contributions")
     * @ORM\JoinColumn(name="album_id", referencedColumnName="id", nullable=false)
     */
    protected $album;

    /**
     * Get id.
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Get artist.
     *
     * @return Artist
     */
    public function getArtist()
    {
        return $this->artist;
    }

    /**
     * Set Artist.
     *
     * @param Artist $artist
     *
     */
    public function setArtist(Artist $artist)
    {
        $this->artist = $artist;
    }

    /**
     * Set Album.
     *
     * @param Album $album
     *
     */
    public function setAlbum(Album $album)
    {
        $this->album = $album;
    }

    /**
     * Set fee.
     *
     * @param float $fee
     *
     * @return Contribution
     */
    public function setFee($fee)
    {
        $this->fee = $fee;

        return $this;
    }

    /**
     * Get fee.
     *
     * @return float
     */
    public function getFee()
    {
        return $this->fee;
    }
}

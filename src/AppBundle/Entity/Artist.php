<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Artist
 *
 * @ORM\Table(name="artist")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ArtistRepository")
 */
class Artist
{

    public function __construct() {
        $this->contributions = new \Doctrine\Common\Collections\ArrayCollection();
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
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="speciality", type="string", length=255)
     */
    private $speciality;

    /**
     * @ORM\OneToMany(targetEntity="Contribution", mappedBy="artist")
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
     * Set name
     *
     * @param string $name
     *
     * @return Artist
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Add contribution
     *
     */
    public function addContribution(Contribution $contribution)
    {
        $this->contributions[] = $contribution;
    }

    /**
     * Get contributions
     *
     * @return arrayCollection
     */
    public function getContributions()
    {
        return $this->contributions;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    public function getTitle()
    {
        return $this->name . ', ' . $this->speciality;
    }


    /**
     * Set speciality
     *
     * @param string $speciality
     *
     * @return Artist
     */
    public function setSpeciality($speciality)
    {
        $this->speciality = $speciality;

        return $this;
    }

    /**
     * Get speciality
     *
     * @return string
     */
    public function getSpeciality()
    {
        return $this->speciality;
    }
}


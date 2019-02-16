<?php

namespace MainBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Outils
 *
 * @ORM\Table(name="outils")
 * @ORM\Entity(repositoryClass="MainBundle\Repository\OutilsRepository")
 */
class Outils
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
     * @var string
     *
     * @ORM\Column(name="Nom", type="string", length=255, unique=true)
     */
    private $nom;

    /**
     * @var int
     *
     * @ORM\Column(name="Quantite", type="integer")
     */
    private $quantite;
    /**
     * @var datetime
     *
     * @ORM\Column(name="dateLocation", type="datetime")
     */
    private $dateLocation;
    /**
     * @var datetime
     *
     * @ORM\Column(name="dateResiliation", type="datetime")
     */
    private $dateResiliation;



    /**
     * @var int
     *
     * @ORM\Column(name="duree", type="integer")
     */
    private $duree;

    /**
     * @ORM\ManyToOne(targetEntity="CategorieOutils")
     * @ORM\JoinColumn(name="idCategorieOutils", referencedColumnName="id")
     */
    private $CategorieOutils;


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
     * Set nom
     *
     * @param string $nom
     *
     * @return Outils
     */
    public function setNom($nom)
    {
        $this->nom = $nom;

        return $this;
    }

    /**
     * Get nom
     *
     * @return string
     */
    public function getNom()
    {
        return $this->nom;
    }

    /**
     * Set quantite
     *
     * @param integer $quantite
     *
     * @return Outils
     */
    public function setQuantite($quantite)
    {
        $this->quantite = $quantite;

        return $this;
    }

    /**
     * Get quantite
     *
     * @return int
     */
    public function getQuantite()
    {
        return $this->quantite;
    }

    /**
     * @return datetime
     */
    public function getDateLocation()
    {
        return $this->dateLocation;
    }

    /**
     * @param datetime $dateLocation
     */
    public function setDateLocation($dateLocation)
    {
        $this->dateLocation = $dateLocation;
    }

    /**
     * @return datetime
     */
    public function getDateResiliation()
    {
        return $this->dateResiliation;
    }

    /**
     * @param datetime $dateResiliation
     */
    public function setDateResiliation($dateResiliation)
    {
        $this->dateResiliation = $dateResiliation;
    }

    /**
     * @return int
     */
    public function getDuree()
    {
        return $this->duree;
    }

    /**
     * @param int $duree
     */
    public function setDuree($duree)
    {
        $this->duree = $duree;
    }

    /**
     * @return mixed
     */
    public function getCategorieOutils()
    {
        return $this->CategorieOutils;
    }

    /**
     * @param mixed $CategorieOutils
     */
    public function setCategorieOutils($CategorieOutils)
    {
        $this->CategorieOutils = $CategorieOutils;
    }
}


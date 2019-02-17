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
     * @var int
     *
     * @ORM\Column(name="dureeMaximale", type="integer")
     */
    private $dureeMaximale;

    /**
     * @var int
     *
     * @ORM\Column(name="prix", type="integer")
     */
    private $prix;

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

    /**
     * @return int
     */
    public function getDureeMaximale()
    {
        return $this->dureeMaximale;
    }

    /**
     * @param int $dureeMaximale
     */
    public function setDureeMaximale($dureeMaximale)
    {
        $this->dureeMaximale = $dureeMaximale;
    }

    /**
     * @return int
     */
    public function getPrix()
    {
        return $this->prix;
    }

    /**
     * @param int $prix
     */
    public function setPrix($prix)
    {
        $this->prix = $prix;
    }

}


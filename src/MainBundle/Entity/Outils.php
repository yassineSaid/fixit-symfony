<?php

namespace MainBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;


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
     * @ORM\Column(name="Nom", type="string", length=255)
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
     * @var string
     *
     * @ORM\Column(name="adresse", type="string")
     */
    private $adresse;
    /**
     * @var int
     *
     * @ORM\Column(name="codePostal", type="integer")
     */
    private $codePostal;
    /**
     * @var string
     *
     * @ORM\Column(name="ville", type="string")
     */
    private $ville;
    /**
     * @var string
     * @Assert\File(mimeTypes={ "image/jpeg", "image/png"})
     * @ORM\Column(name="image", type="string")
     */
    private $image;

    /**
     *
     * @ORM\ManyToOne(targetEntity="CategorieOutils")
     * @ORM\JoinColumn(name="idCategorieOutils", referencedColumnName="id", onDelete="CASCADE")
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

    /**
     * @return string
     */
    public function getAdresse()
    {
        return $this->adresse;
    }

    /**
     * @param string $adresse
     */
    public function setAdresse($adresse)
    {
        $this->adresse = $adresse;
    }

    /**
     * @return int
     */
    public function getCodePostal()
    {
        return $this->codePostal;
    }

    /**
     * @param int $codePostal
     */
    public function setCodePostal($codePostal)
    {
        $this->codePostal = $codePostal;
    }

    /**
     * @return string
     */
    public function getVille()
    {
        return $this->ville;
    }

    /**
     * @param string $ville
     */
    public function setVille($ville)
    {
        $this->ville = $ville;
    }

    /**
     * @return string
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * @param string $image
     */
    public function setImage($image)
    {
        $this->image = $image;
    }

}


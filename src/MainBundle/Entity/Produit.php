<?php

namespace MainBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Produit
 *
 * @ORM\Table(name="produit")
 * @ORM\Entity(repositoryClass="MainBundle\Repository\ProduitRepository")
 */
class Produit
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
     * @return mixed
     */
    public function getCategorieProduit()
    {
        return $this->CategorieProduit;
    }

    /**
     * @param mixed $CategorieProduit
     */
    public function setCategorieProduit($CategorieProduit)
    {
        $this->CategorieProduit = $CategorieProduit;
    }

    /**
     * @var int
     *
     * @ORM\Column(name="Quantite", type="integer")
     */
    private $quantite;
    /**
     * @ORM\ManyToOne(targetEntity="CategorieProduit")
     * @ORM\JoinColumn(name="idCategorieProduit", referencedColumnName="id", onDelete="CASCADE")
     */
    private $CategorieProduit;
    /**
     * @ORM\ManyToOne(targetEntity="User")
     * @ORM\JoinColumn(name="user", referencedColumnName="id")
     */
    private $user;

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
    /**
     * @var string
     * @Assert\File(mimeTypes={ "image/jpeg", "image/png"})
     * @ORM\Column(name="image", type="string")
     */
    private $image;
    /**
     * @return int
     */
    public function getPrix()
    {
        return $this->prix;
    }

    /**
     * @return mixed
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @param mixed $user
     */
    public function setUser($user)
    {
        $this->user = $user;
    }

    /**
     * @param int $prix
     */
    public function setPrix($prix)
    {
        $this->prix = $prix;
    }
    /**
     * @var int
     *
     * @ORM\Column(name="prix", type="integer")
     */
    private $prix;

    /**
     * @var datetime
     *
     * @ORM\Column(name="date_exp", type="datetime" )
     */
    private $dateExp;
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
     * @return Produit
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
     * @return Produit
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
     * @param int $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return datetime
     */
    public function getDateExp()
    {
        return $this->dateExp;
    }

    /**
     * @param datetime $dateExp
     */
    public function setDateExp($dateExp)
    {
        $this->dateExp = $dateExp;
    }



}


<?php

namespace MainBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

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
     * @ORM\JoinColumn(name="idCategorieProduit", referencedColumnName="id")
     */
    private $CategorieProduit;
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
}


<?php

namespace MainBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * AchatProduit
 *
 * @ORM\Table(name="achat_produit")
 * @ORM\Entity(repositoryClass="MainBundle\Repository\AchatProduitRepository")
 */
class AchatProduit
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
     * @var int
     *
     * @ORM\Column(name="Produit", type="string", length=255,)
     */
    private $produit;

    /**
     * @return int
     */
    public function getIdProduit()
    {
        return $this->idProduit;
    }

    /**
     * @param int $idProduit
     */
    public function setIdProduit($idProduit)
    {
        $this->idProduit = $idProduit;
    }
    /**
     * @var int
     *
     * @ORM\Column(name="idProduit", type="integer")
     */
    private $idProduit;

    /**
     * @var string
     *
     * @ORM\Column(name="acheteur", type="string", length=255, nullable=true)
     */
    private $acheteur;

    /**
     * @return datetime
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * @param datetime $date
     */
    public function setDate($date)
    {
        $this->date = $date;
    }
    /**
     * @var datetime
     *
     * @ORM\Column(name="date", type="datetime" )
     */
    private $date;
    /**
     * @var int
     *
     * @ORM\Column(name="quantite", type="integer")
     */
    private $quantite;

    /**
     * @return int
     */
    public function getIdAcheteur()
    {
        return $this->idAcheteur;
    }

    /**
     * @param int $idAcheteur
     */
    public function setIdAcheteur($idAcheteur)
    {
        $this->idAcheteur = $idAcheteur;
    }
    /**
     * @var int
     *
     * @ORM\Column(name="idAcheteur", type="integer")
     */
    private $idAcheteur;

    /**
     * @var int
     *
     * @ORM\Column(name="prix", type="integer")
     */
    private $prix;

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
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set produit
     *
     * @param integer $produit
     *
     * @return AchatProduit
     */
    public function setProduit($produit)
    {
        $this->produit = $produit;

        return $this;
    }

    /**
     * Get produit
     *
     * @return int
     */
    public function getProduit()
    {
        return $this->produit;
    }

    /**
     * Set acheteur
     *
     * @param string $acheteur
     *
     * @return AchatProduit
     */
    public function setAcheteur($acheteur)
    {
        $this->acheteur = $acheteur;

        return $this;
    }

    /**
     * Get acheteur
     *
     * @return string
     */
    public function getAcheteur()
    {
        return $this->acheteur;
    }

    /**
     * Set quantite
     *
     * @param integer $quantite
     *
     * @return AchatProduit
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
     * Set prix
     *
     * @param integer $prix
     *
     * @return AchatProduit
     */
    public function setPrix($prix)
    {
        $this->prix = $prix;

        return $this;
    }

    /**
     * Get prix
     *
     * @return int
     */
    public function getPrix()
    {
        return $this->prix;
    }
}


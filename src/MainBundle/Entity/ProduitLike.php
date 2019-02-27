<?php

namespace MainBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ProduitLike
 *
 * @ORM\Table(name="produit_like")
 * @ORM\Entity(repositoryClass="MainBundle\Repository\ProduitLikeRepository")
 */
class ProduitLike
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
     * @ORM\ManyToOne(targetEntity="Produit")
     * @ORM\JoinColumn(name="produit", referencedColumnName="id", onDelete="CASCADE")
     */
    private $produit;

    /**
     * @var int
     *
     * @ORM\ManyToOne(targetEntity="User")
     * @ORM\JoinColumn(name="user", referencedColumnName="id")
     */
    private $user;


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
     * @return ProduitLike
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
     * Set user
     *
     * @param integer $user
     *
     * @return ProduitLike
     */
    public function setUser($user)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return int
     */
    public function getUser()
    {
        return $this->user;
    }
}


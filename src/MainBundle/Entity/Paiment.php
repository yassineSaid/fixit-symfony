<?php

namespace MainBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Paiment
 *
 * @ORM\Table(name="paiment")
 * @ORM\Entity(repositoryClass="MainBundle\Repository\PaimentRepository")
 */
class Paiment
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
     * @ORM\Column(name="Montant", type="float")
     */
    private $montant;

    /**
     * @var int
     *
     * @ORM\Column(name="NombreScoin", type="integer")
     */
    private $nombreScoin;


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
     * Set montant
     *
     * @param float $montant
     *
     * @return Paiment
     */
    public function setMontant($montant)
    {
        $this->montant = $montant;

        return $this;
    }

    /**
     * Get montant
     *
     * @return float
     */
    public function getMontant()
    {
        return $this->montant;
    }

    /**
     * Set nombreScoin
     *
     * @param integer $nombreScoin
     *
     * @return Paiment
     */
    public function setNombreScoin($nombreScoin)
    {
        $this->nombreScoin = $nombreScoin;

        return $this;
    }

    /**
     * Get nombreScoin
     *
     * @return int
     */
    public function getNombreScoin()
    {
        return $this->nombreScoin;
    }
}


<?php

namespace MainBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Paiement
 *
 * @ORM\Table(name="paiement")
 * @ORM\Entity(repositoryClass="MainBundle\Repository\PaiementRepository")
 */
class Paiement
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
     * @ORM\ManyToOne(targetEntity="User")
     * @ORM\JoinColumn(name="IdUser", referencedColumnName="id")
     */
    private $IdUser;

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
     * @var string
     *
     * @ORM\Column(name="stripeToken", type="string")
     */
    private $stripeToken;

    /**
     * @var datetime
     *
     * @ORM\Column(name="datePaiement", type="datetime")
     */
    private $datePaiement;



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

    /**
     * @return string
     */
    public function getStripeToken()
    {
        return $this->stripeToken;
    }

    /**
     * @param string $stripeToken
     */
    public function setStripeToken($stripeToken)
    {
        $this->stripeToken = $stripeToken;
    }

    /**
     * @return mixed
     */
    public function getIdUser()
    {
        return $this->IdUser;
    }

    /**
     * @param mixed $IdUser
     */
    public function setIdUser($IdUser)
    {
        $this->IdUser = $IdUser;
    }

    /**
     * @return datetime
     */
    public function getDatePaiement()
    {
        return $this->datePaiement;
    }

    /**
     * @param datetime $datePaiement
     */
    public function setDatePaiement($datePaiement)
    {
        $this->datePaiement = $datePaiement;
    }

}


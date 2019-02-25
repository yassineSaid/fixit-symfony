<?php

namespace MainBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * HistoriqueLocation
 *
 * @ORM\Table(name="historique_location")
 * @ORM\Entity(repositoryClass="MainBundle\Repository\HistoriqueLocationRepository")
 */
class HistoriqueLocation
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
     * @ORM\Column(name="idUser",type="integer")
     */
    private $idUser;
    /**
     * @var int
     * @ORM\Column(name="idOutil",type="integer")
     */
    private $idOutil;
    /**
     * @var date
     *
     * @ORM\Column(name="dateLocation", type="date")
     */
    private $dateLocation;
    /**
     * @var date
     *
     * @ORM\Column(name="dateRetour", type="date")
     */
    private $dateRetour;
    /**
     * @var int
     *
     * @ORM\Column(name="total", type="integer")
     */
    private $total;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return int
     */
    public function getIdUser()
    {
        return $this->idUser;
    }

    /**
     * @param int $idUser
     */
    public function setIdUser($idUser)
    {
        $this->idUser = $idUser;
    }

    /**
     * @return int
     */
    public function getIdOutil()
    {
        return $this->idOutil;
    }

    /**
     * @param int $idOutil
     */
    public function setIdOutil($idOutil)
    {
        $this->idOutil = $idOutil;
    }

    /**
     * @return date
     */
    public function getDateLocation()
    {
        return $this->dateLocation;
    }

    /**
     * @param date $dateLocation
     */
    public function setDateLocation($dateLocation)
    {
        $this->dateLocation = $dateLocation;
    }

    /**
     * @return date
     */
    public function getDateRetour()
    {
        return $this->dateRetour;
    }

    /**
     * @param date $dateRetour
     */
    public function setDateRetour($dateRetour)
    {
        $this->dateRetour = $dateRetour;
    }

    /**
     * @return int
     */
    public function getTotal()
    {
        return $this->total;
    }

    /**
     * @param int $total
     */
    public function setTotal($total)
    {
        $this->total = $total;
    }




}


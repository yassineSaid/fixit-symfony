<?php

namespace MainBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * UserOutil
 *
 * @ORM\Table(name="user_outil")
 * @ORM\Entity(repositoryClass="MainBundle\Repository\UserOutilRepository")
 */
class UserOutil
{
    /**
     * @var int
     * @ORM\Id
     * @ORM\ManyToOne(targetEntity="User")
     * @ORM\JoinColumn(name="idUser",referencedColumnName="id")
     */
    private $idUser;
    /**
     * @var int
     * @ORM\Id
     * @ORM\ManyToOne(targetEntity="Outils")
     * @ORM\JoinColumn(name="idOutil",referencedColumnName="id")
     */
    private $idOutil;
    /**
     * @var datetime
     *
     * @ORM\Column(name="dateLocation", type="datetime")
     */
    private $dateLocation;
    /**
     * @var datetime
     *
     * @ORM\Column(name="dateRetour", type="datetime")
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
    public function getDateRetour()
    {
        return $this->dateRetour;
    }

    /**
     * @param datetime $dateRetour
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


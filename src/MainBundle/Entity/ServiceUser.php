<?php

namespace MainBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ServiceUser
 *
 * @ORM\Table(name="service_user")
 * @ORM\Entity(repositoryClass="MainBundle\Repository\ServiceUserRepository")
 */
class ServiceUser
{
    /**
     * @ORM\Id
     * @ORM\ManyToOne(targetEntity="User")
     * @ORM\JoinColumn(name="idUser", referencedColumnName="id")
     */
    private $idUser;
    /**
     * @ORM\Id
     * @ORM\ManyToOne(targetEntity="Service")
     * @ORM\JoinColumn(name="idService", referencedColumnName="id")
     */
    private $idService;
    /**
     * @var integer
     *
     * @ORM\Column(name="prix", type="integer")
     */
    private $prix;

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
     * @return mixed
     */
    public function getIdUser()
    {
        return $this->idUser;
    }

    /**
     * @param mixed $idUser
     */
    public function setIdUser($idUser)
    {
        $this->idUser = $idUser;
    }

    /**
     * @return mixed
     */
    public function getIdService()
    {
        return $this->idService;
    }

    /**
     * @param mixed $idService
     */
    public function setIdService($idService)
    {
        $this->idService = $idService;
    }
}


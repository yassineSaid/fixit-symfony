<?php

namespace MainBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * UserLangue
 *
 * @ORM\Table(name="user_langue")
 * @ORM\Entity(repositoryClass="MainBundle\Repository\UserLangueRepository")
 */
class UserLangue
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
     * @ORM\ManyToOne(targetEntity="Langue")
     * @ORM\JoinColumn(name="idLangue",referencedColumnName="id")
     */
    private $idLangue;

    /**
     * UserLangue constructor.
     * @param int $idUser
     * @param int $idLangue
     */
    public function __construct($idUser, $idLangue)
    {
        $this->idUser = $idUser;
        $this->idLangue = $idLangue;
    }

    /**
     * Set idUser
     *
     * @param integer $idUser
     *
     * @return UserLangue
     */
    
    public function setIdUser($idUser)
    {
        $this->idUser = $idUser;

        return $this;
    }

    /**
     * Get idUser
     *
     * @return int
     */
    public function getIdUser()
    {
        return $this->idUser;
    }

    /**
     * Set idLangue
     *
     * @param integer $idLangue
     *
     * @return UserLangue
     */
    public function setIdLangue($idLangue)
    {
        $this->idLangue = $idLangue;

        return $this;
    }

    /**
     * Get idLangue
     *
     * @return int
     */
    public function getIdLangue()
    {
        return $this->idLangue;
    }
}


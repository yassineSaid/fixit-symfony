<?php

namespace MainBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Repos
 *
 * @ORM\Table(name="repos")
 * @ORM\Entity(repositoryClass="MainBundle\Repository\ReposRepository")
 */
class Repos
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     */
    private $id;

    /**
     * @var int
     * @ORM\Id
     * @ORM\ManyToOne(targetEntity="User")
     * @ORM\JoinColumn(name="User",referencedColumnName="id")
     */
    private $User;


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
     * @param int $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return int
     */
    public function getUser()
    {
        return $this->User;
    }

    /**
     * @param int $User
     */
    public function setUser($User)
    {
        $this->User = $User;
    }

}


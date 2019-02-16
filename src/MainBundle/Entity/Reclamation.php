<?php

namespace MainBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints\Date;

/**
 * Reclamation
 *
 * @ORM\Table(name="reclamation")
 * @ORM\Entity(repositoryClass="MainBundle\Repository\ReclamationRepository")
 */
class Reclamation
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
     * @ORM\Column(name="Object", type="string", length=255)
     */
    private $object;

    /**
     * @var string
     *
     * @ORM\Column(name="Description", type="string", length=255)
     */
    private $description;
    /**
     * @var \DateTime
     *
     * @ORM\Column(name="DateReclamation", type="date")
     */
    private $DateReclamation;

    /**
     * @ORM\ManyToOne(targetEntity="User")
     * @ORM\JoinColumn(name="userreclame", referencedColumnName="id")
     */
    private $userreclame;
    /**
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
     * Set object
     *
     * @param string $object
     *
     * @return Reclamation
     */
    public function setObject($object)
    {
        $this->object = $object;

        return $this;
    }

    /**
     * Get object
     *
     * @return string
     */
    public function getObject()
    {
        return $this->object;
    }

    /**
     * Set description
     *
     * @param string $description
     *
     * @return Reclamation
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @return mixed
     */
    public function getUserreclame()
    {
        return $this->userreclame;
    }

    /**
     * @param mixed $userreclame
     */
    public function setUserreclame($userreclame)
    {
        $this->userreclame = $userreclame;
    }

    /**
     * @return \DateTime
     */
    public function getDateReclamation()
    {
        return $this->DateReclamation;
    }

    /**
     * @param \DateTime $DateReclamation
     */
    public function setDateReclamation($DateReclamation)
    {
        $this->DateReclamation = $DateReclamation;
    }

    /**
     * @return mixed
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @param mixed $user
     */
    public function setUser($user)
    {
        $this->user = $user;
    }





}


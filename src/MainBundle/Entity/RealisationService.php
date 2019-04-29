<?php

namespace MainBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * RealisationService
 *
 * @ORM\Table(name="realisation_service")
 * @ORM\Entity(repositoryClass="MainBundle\Repository\RealisationServiceRepository")
 */
class RealisationService
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
     * @ORM\JoinColumn(name="idUserDemandeur", referencedColumnName="id")
     */
    private $UserDemandeur;

    /**
     * @ORM\ManyToOne(targetEntity="User")
     * @ORM\JoinColumn(name="idUserOffreur", referencedColumnName="id")
     */
    private $UserOffreur;

    /**
     * @ORM\ManyToOne(targetEntity="Service")
     * @ORM\JoinColumn(name="idservice", referencedColumnName="id" , onDelete="CASCADE")
     */

    private $service;

    /**
     * @var int
     *
     * @ORM\Column(name="note", type="integer")
     */
    private $note;
    /**
     * @var \DateTime
     *
     * @ORM\Column(name="DateRealisation", type="date")
     */
    private $DateRealisation;


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
     * @return mixed
     */
    public function getUserDemandeur()
    {
        return $this->UserDemandeur;
    }

    /**
     * @return mixed
     */
    public function getUserOffreur()
    {
        return $this->UserOffreur;
    }

    /**
     * @param mixed $UserOffreur
     */
    public function setUserOffreur($UserOffreur)
    {
        $this->UserOffreur = $UserOffreur;
    }

    /**
     * @return mixed
     */
    public function getService()
    {
        return $this->service;
    }

    /**
     * @param mixed $service
     */
    public function setService($service)
    {
        $this->service = $service;
    }


    /**
     * @return \DateTime
     */
    public function getDateRealisation()
    {
        return $this->DateRealisation;
    }

    /**
     * @param int $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @param mixed $UserDemandeur
     */
    public function setUserDemandeur($UserDemandeur)
    {
        $this->UserDemandeur = $UserDemandeur;
    }

    /**
     * @param \DateTime $DateRealisation
     */
    public function setDateRealisation($DateRealisation)
    {
        $this->DateRealisation = $DateRealisation;
    }

    /**
     * @return int
     */
    public function getNote()
    {
        return $this->note;
    }

    /**
     * @param int $note
     */
    public function setNote($note)
    {
        $this->note = $note;
    }




}


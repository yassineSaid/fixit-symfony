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
     * @ORM\JoinColumn(name="idservice", referencedColumnName="id")
     */

    private $service;

    /**
     * @ORM\ManyToOne(targetEntity="Outils")
     * @ORM\JoinColumn(name="idoutil", referencedColumnName="id")
     */
    private $outil;


    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }
}


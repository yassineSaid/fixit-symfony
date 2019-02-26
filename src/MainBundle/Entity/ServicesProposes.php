<?php

namespace MainBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ServicesProposes
 *
 * @ORM\Table(name="services_proposes")
 * @ORM\Entity(repositoryClass="MainBundle\Repository\ServicesProposesRepository")
 */
class ServicesProposes
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
     * @ORM\Column(name="nomService", type="string", length=255)
     */
    private $nomService;

    /**
     * @var string
     *
     * @ORM\Column(name="categorieService", type="string", length=255)
     */
    private $categorieService;
    /**
     * @var string
     *
     * @ORM\Column(name="description", type="string", length=255)
     */
    private $description;

    /**
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param string $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }


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
     * Set nomService
     *
     * @param string $nomService
     *
     * @return ServicesProposes
     */
    public function setNomService($nomService)
    {
        $this->nomService = $nomService;

        return $this;
    }

    /**
     * Get nomService
     *
     * @return string
     */
    public function getNomService()
    {
        return $this->nomService;
    }

    /**
     * Set categorieService
     *
     * @param string $categorieService
     *
     * @return ServicesProposes
     */
    public function setCategorieService($categorieService)
    {
        $this->categorieService = $categorieService;

        return $this;
    }

    /**
     * Get categorieService
     *
     * @return string
     */
    public function getCategorieService()
    {
        return $this->categorieService;
    }
}


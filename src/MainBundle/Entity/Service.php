<?php

namespace MainBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Service
 *
 * @ORM\Table(name="service")
 * @ORM\Entity(repositoryClass="MainBundle\Repository\ServiceRepository")
 */
class Service
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
     * @ORM\Column(name="Nom", type="string", length=255, unique=true)
     */
    private $nom;

    /**
     * @ORM\ManyToOne(targetEntity="CategorieService")
     * @ORM\JoinColumn(name="idCategorieService", referencedColumnName="id")
     */
    private $CategorieService;
    /**
     * @var integer
     *
     * @ORM\Column(name="NbrProviders", type="integer")
     */
    private $NbrProviders;

    /**
     * @return string
     */
    public function getNbrProviders()
    {
        return $this->NbrProviders;
    }

    /**
     * @param integer $NbrProviders
     */
    public function setNbrProviders($NbrProviders)
    {
        $this->NbrProviders = $NbrProviders;
    }

    /**
     * @return mixed
     */
    public function getCategorieService()
    {
        return $this->CategorieService;
    }

    /**
     * @param mixed $CategorieService
     */
    public function setCategorieService($CategorieService)
    {
        $this->CategorieService = $CategorieService;
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
     * Set nom
     *
     * @param string $nom
     *
     * @return Service
     */
    public function setNom($nom)
    {
        $this->nom = $nom;

        return $this;
    }

    /**
     * Get nom
     *
     * @return string
     */
    public function getNom()
    {
        return $this->nom;
    }
}


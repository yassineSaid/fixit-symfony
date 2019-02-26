<?php

namespace MainBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

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
     * @ORM\Column(name="prixMini", type="integer")
     */
    private $prixMini;

    /**
     * @return int
     */
    public function getPrixMini()
    {
        return $this->prixMini;
    }

    /**
     * @param int $prixMini
     */
    public function setPrixMini($prixMini)
    {
        $this->prixMini = $prixMini;
    }

    /**
     * @return int
     */
    public function getPrixMax()
    {
        return $this->prixMax;
    }

    /**
     * @param int $prixMax
     */
    public function setPrixMax($prixMax)
    {
        $this->prixMax = $prixMax;
    }

    /**
     * @var integer
     *
     * @ORM\Column(name="prixMax", type="integer")
     */
    private $prixMax;

    /**
     * @var integer
     *
     * @ORM\Column(name="visible", type="integer")
     */
    private $visible;

    /**
     * @return int
     */
    public function getVisible()
    {
        return $this->visible;
    }

    /**
     * @param int $visible
     */
    public function setVisible($visible)
    {
        $this->visible = $visible;
    }


    /**
     * @var integer
     *
     * @ORM\Column(name="NbrProviders", type="integer")
     */
    private $NbrProviders;
    /**
     * @var string
     * @Assert\File(mimeTypes={ "image/jpeg", "image/png"})
     * @ORM\Column(name="image_service", type="string" , nullable=true)
     */
    private $imageService;


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
    public function getImageService()
    {
        return $this->imageService;
    }

    /**
     * @param string $imageService
     */
    public function setImageService($imageService)
    {
        $this->imageService = $imageService;
    }


}


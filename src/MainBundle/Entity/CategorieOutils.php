<?php

namespace MainBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

use Symfony\Component\Validator\Constraints as Assert;

/**
 * CategorieOutils
 *
 * @ORM\Table(name="categorie_outils")
 * @ORM\Entity(repositoryClass="MainBundle\Repository\CategorieOutilsRepository")
 */
class CategorieOutils
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
     * @var string
     * @Assert\File(mimeTypes={ "image/jpeg", "image/png"})
     * @ORM\Column(name="logo", type="string")
     */
    private $logo;

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
     * @return CategorieOutils
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

    /**
     * @return string
     */
    public function getLogo()
    {
        return $this->logo;
    }

    /**
     * @param string $logo
     */
    public function setLogo($logo)
    {
        $this->logo = $logo;
    }

}


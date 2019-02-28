<?php

namespace MainBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Annonce
 *
 * @ORM\Table(name="annonce")
 * @ORM\Entity(repositoryClass="MainBundle\Repository\AnnonceRepository")
 */
class Annonce
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
     * @ORM\Column(name="Description", type="string", length=255)
     */
    private $description;
    /**
     * @var string
     *
     * @ORM\Column(name="type", type="string", length=255)
     */
    private $type;

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
     * @var integer
     *
     * @ORM\Column(name="montant", type="integer")
     */
    private $prix;

    /**
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param string $type
     */
    public function setType($type)
    {
        $this->type = $type;
    }
    /**
     * @var string
     *
     * @ORM\Column(name="adresse", type="string", length=255)
     */
    private $adresse;

    /**
     * @return \DateTime
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * @param \DateTime $date
     */
    public function setDate($date)
    {
        $this->date = $date;
    }
    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="datetime")
     */
    private $date;




    /**
     * @var integer
     *
     * @ORM\Column(name="tel", type="integer")
     */
    private $tel;
    /**
     * @var integer
     *
     * @ORM\Column(name="nbr_c", type="integer")
     */
    private $nbrC;
    /**
     * @var integer
     *
     * @ORM\Column(name="nbr_d", type="integer")
     */
    private $nbrD;

    /**
     * @return int
     */
    public function getNbrD()
    {
        return $this->nbrD;
    }

    /**
     * @param int $nbrD
     */
    public function setNbrD($nbrD)
    {
        $this->nbrD = $nbrD;
    }

    /**
     * @return int
     */
    public function getNbrO()
    {
        return $this->nbrO;
    }

    /**
     * @param int $nbrO
     */
    public function setNbrO($nbrO)
    {
        $this->nbrO = $nbrO;
    }


    /**
     * @var integer
     *
     * @ORM\Column(name="nbr_o", type="integer")
     */
    private $nbrO;

    /**
     * @return int
     */
    public function getNbrC()
    {
        return $this->nbrC;
    }

    /**
     * @param int $nbrC
     */
    public function setNbrC($nbrC)
    {
        $this->nbrC = $nbrC;
    }
    /**
     * @ORM\ManyToOne(targetEntity="User")
     * @ORM\JoinColumn(name="IdUser", referencedColumnName="id")
     */
    private $User;

    /**
     * @return mixed
     */
    public function getService()
    {
        return $this->Service;
    }

    /**
     * @param mixed $Service
     */
    public function setService($Service)
    {
        $this->Service = $Service;
    }
    /**
     * @ORM\ManyToOne(targetEntity="Service")
     * @ORM\JoinColumn(name="IdService", referencedColumnName="id")
     */
    private $Service;
    /**
     * @ORM\OneToMany(targetEntity="Candidature", mappedBy="annonce",cascade={"remove"} )
     */
    private $candidatures;

    public function __construct()
    {
        $this->setDate(new \DateTime());
        $this->candidatures = new ArrayCollection();
    }

    /**
     * @ORM\ManyToOne(targetEntity="CategorieService")
     * @ORM\JoinColumn(name="CategorieService", referencedColumnName="id")
     */
    private $CategorieService;


    /**
     * @return mixed
     */
    public function getCategorieService()
    {
        return $this->CategorieService;
    }

    /**
     * @return mixed
     */
    public function getCandidatures()
    {
        return $this->candidatures;
    }

    /**
     * @param mixed $candidatures
     */
    public function setCandidatures($candidatures)
    {
        $this->candidatures = $candidatures;
    }

    /**
     * @return mixed
     */
    public function getUser()
    {
        return $this->User;
    }

    /**
     * @param mixed $User
     */
    public function setUser($User)
    {
        $this->User = $User;
    }

    /**
     * @param mixed $CategorieService
     */
    public function setCategorieService($CategorieService)
    {
        $this->CategorieService = $CategorieService;
    }

    /**
     * @return integer
     */
    public function getTel()
    {
        return $this->tel;
    }

    /**
     * @param integer $tel
     */
    public function setTel($tel)
    {
        $this->tel = $tel;
    }

    /**
     * @return string
     */
    public function getAdresse()
    {
        return $this->adresse;
    }

    /**
     * @param string $adresse
     */
    public function setAdresse($adresse)
    {
        $this->adresse = $adresse;
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
     * Set description
     *
     * @param string $description
     *
     * @return Annonce
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
}


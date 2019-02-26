<?php

namespace MainBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * HistoriqueService
 *
 * @ORM\Table(name="historique_service")
 * @ORM\Entity(repositoryClass="MainBundle\Repository\HistoriqueServiceRepository")
 */
class HistoriqueService
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
     * @var integer
     *
     * @ORM\Column(name="idService", type="integer")
     */

    private $idService;

    /**
     * @return int
     */
    public function getIdService()
    {
        return $this->idService;
    }

    /**
     * @param int $idService
     */
    public function setIdService($idService)
    {
        $this->idService = $idService;
    }
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
     * @var \DateTime
     *
     * @ORM\Column(name="dateSuppression", type="datetime")
     */
    private $dateSuppression;
    /**
     * @var string
     *
     * @ORM\Column(name="actions", type="string", length=255)
     */
    private $actions;

    /**
     * @return string
     */
    public function getActions()
    {
        return $this->actions;
    }

    /**
     * @param string $actions
     */
    public function setActions($actions)
    {
        $this->actions = $actions;
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
     * @return HistoriqueService
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
     * @return HistoriqueService
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

    /**
     * Set dateSuppression
     *
     * @param \DateTime $dateSuppression
     *
     * @return HistoriqueService
     */
    public function setDateSuppression($dateSuppression)
    {
        $this->dateSuppression = $dateSuppression;

        return $this;
    }

    /**
     * Get dateSuppression
     *
     * @return \DateTime
     */
    public function getDateSuppression()
    {
        return $this->dateSuppression;
    }
}


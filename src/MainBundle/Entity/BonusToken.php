<?php

namespace MainBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * BonusToken
 *
 * @ORM\Table(name="bonus_token")
 * @ORM\Entity(repositoryClass="MainBundle\Repository\BonusTokenRepository")
 */
class BonusToken
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
     * @ORM\JoinColumn(name="userreclame", referencedColumnName="id")
     */
    private $user;
    /**
     * @var \DateTime
     *
     * @ORM\Column(name="datearrtibution", type="date")
     */
    private $datearrtibution;
    /**
     * @var int
     *
     * @ORM\Column(name="montant", type="integer")
     */
    private $montant;

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
     * Set datearrtibution
     *
     * @param \DateTime $datearrtibution
     *
     * @return BonusToken
     */
    public function setDatearrtibution($datearrtibution)
    {
        $this->datearrtibution = $datearrtibution;

        return $this;
    }

    /**
     * Get datearrtibution
     *
     * @return \DateTime
     */
    public function getDatearrtibution()
    {
        return $this->datearrtibution;
    }
}


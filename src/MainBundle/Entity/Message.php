<?php

namespace MainBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Message
 *
 * @ORM\Table(name="message")
 * @ORM\Entity(repositoryClass="MainBundle\Repository\MessageRepository")
 */
class Message
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
     * @ORM\JoinColumn(name="expediteur", referencedColumnName="id")
     */
    private $expediteur;

    /**
     * @ORM\ManyToOne(targetEntity="User")
     * @ORM\JoinColumn(name="destinataire", referencedColumnName="id")
     */
    private $destinataire;

    /**
     * @var string
     *
     * @ORM\Column(name="contenu", type="text")
     */
    private $contenu;

    /**
     * @var int
     *
     * @ORM\Column(name="vu", type="integer", length=1)
     */
    private $vu;

    /**
     * @var int
     *
     * @ORM\Column(name="notified", type="integer", length=1)
     */
    private $notified;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="datetime")
     */
    private $date;


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
     * Set contenu
     *
     * @param string $contenu
     *
     * @return Message
     */
    public function setContenu($contenu)
    {
        $this->contenu = $contenu;

        return $this;
    }

    /**
     * Get contenu
     *
     * @return string
     */
    public function getContenu()
    {
        return $this->contenu;
    }

    /**
     * Set vu
     *
     * @param int $vu
     *
     * @return Message
     */
    public function setVu($vu)
    {
        $this->vu = $vu;

        return $this;
    }

    /**
     * Get vu
     *
     * @return int
     */
    public function getVu()
    {
        return $this->vu;
    }

    /**
     * Set notified
     *
     * @param int $notified
     *
     * @return Message
     */
    public function setNotified($notified)
    {
        $this->notified = $notified;

        return $this;
    }

    /**
     * Get notified
     *
     * @return int
     */
    public function getNotified()
    {
        return $this->notified;
    }

    /**
     * Set date
     *
     * @param \DateTime $date
     *
     * @return Message
     */
    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * Get date
     *
     * @return \DateTime
     */
    public function getDate()
    {
        return $this->date;
    }

}


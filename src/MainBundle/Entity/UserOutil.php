<?php

namespace MainBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use SBC\NotificationsBundle\Builder\NotificationBuilder;
use SBC\NotificationsBundle\Model\NotifiableInterface;
use Symfony\Component\Validator\Constraints\DateTime;

/**
 * UserOutil
 *
 * @ORM\Table(name="user_outil")
 * @ORM\Entity(repositoryClass="MainBundle\Repository\UserOutilRepository")
 */
class UserOutil implements NotifiableInterface
{
    /**
     * @var int
     * @ORM\Id
     * @ORM\ManyToOne(targetEntity="User")
     * @ORM\JoinColumn(name="idUser",referencedColumnName="id", onDelete="CASCADE")
     */
    private $idUser;
    /**
     * @var int
     * @ORM\Id
     * @ORM\ManyToOne(targetEntity="Outils")
     * @ORM\JoinColumn(name="idOutil",referencedColumnName="id", onDelete="CASCADE")
     */
    private $idOutil;
    /**
     * @var date
     *
     * @ORM\Column(name="dateLocation", type="date")
     */
    private $dateLocation;
    /**
     * @var date
     *
     * @ORM\Column(name="dateRetour", type="date")
     */
    private $dateRetour;
    /**
     * @var int
     *
     * @ORM\Column(name="total", type="integer")
     */
    private $total;

    /**
     * @return int
     */
    public function getIdUser()
    {
        return $this->idUser;
    }

    /**
     * @param int $idUser
     */
    public function setIdUser($idUser)
    {
        $this->idUser = $idUser;
    }

    /**
     * @return int
     */
    public function getIdOutil()
    {
        return $this->idOutil;
    }

    /**
     * @param int $idOutil
     */
    public function setIdOutil($idOutil)
    {
        $this->idOutil = $idOutil;
    }

    /**
     * @return datetime
     */
    public function getDateLocation()
    {
        return $this->dateLocation;
    }

    /**
     * @param datetime $dateLocation
     */
    public function setDateLocation($dateLocation)
    {
        $this->dateLocation = $dateLocation;
    }

    /**
     * @return datetime
     */
    public function getDateRetour()
    {
        return $this->dateRetour;
    }

    /**
     * @param datetime $dateRetour
     */
    public function setDateRetour($dateRetour)
    {
        $this->dateRetour = $dateRetour;
    }

    /**
     * @return int
     */
    public function getTotal()
    {
        return $this->total;
    }

    /**
     * @param int $total
     */
    public function setTotal($total)
    {
        $this->total = $total;
    }

    public function notificationsOnCreate(NotificationBuilder $builder)
    {
        $date =$this->dateLocation;
        echo $date->format('Y-m-d ');
        $d = new \DateTime();
        //echo $d->format('Y-m-d ');
        $notificataion= new Notification();
        $notificataion->setTitle("Location");
        $notificataion->setDescription($this->idUser." va louer l'outil ".$this->idOutil->getNom()." le ".$date->format('Y-m-d')."         ".$d->format('Y-m-d H:i:s'));
        $notificataion->setIcon($this->idOutil->getImage());
        $builder->addNotification($notificataion);
        return $builder;
    }

    public function notificationsOnUpdate(NotificationBuilder $builder)
    {

        $notificataion= new Notification();
        $notificataion->setTitle("Location");
        $notificataion->setDescription($this->idUser." va louer l'outil".$this->idOutil."le");
        $builder->addNotification($notificataion);
        return $builder;
    }

    public function notificationsOnDelete(NotificationBuilder $builder)
    {
        return $builder;
    }


}


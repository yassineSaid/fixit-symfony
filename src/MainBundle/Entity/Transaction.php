<?php

namespace MainBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Transaction
 *
 * @ORM\Table(name="transaction")
 * @ORM\Entity(repositoryClass="MainBundle\Repository\TransactionRepository")
 */
class Transaction
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
     * @var int
     *
     * @ORM\Column(name="MonatantScoin", type="integer")
     */
    private $monatantScoin;

    /**
     * @var datetime
     *
     * @ORM\Column(name="date", type="datetime")
     */
    private $date;

    /**
     * @var string
     *
     * @ORM\Column(name="type", type="string")
     */
    private $type;

    /**
     * @ORM\ManyToOne(targetEntity="User")
     * @ORM\JoinColumn(name="iduserPayant", referencedColumnName="id")
     */

    private $UserP;
    /**
     * @ORM\ManyToOne(targetEntity="User")
     * @ORM\JoinColumn(name="idUserRecevant", referencedColumnName="id")
     */
    private $UserR;



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
     * Set monatantScoin
     *
     * @param integer $monatantScoin
     *
     * @return Transaction
     */
    public function setMonatantScoin($monatantScoin)
    {
        $this->monatantScoin = $monatantScoin;

        return $this;
    }

    /**
     * Get monatantScoin
     *
     * @return int
     */
    public function getMonatantScoin()
    {
        return $this->monatantScoin;
    }

    /**
     * @return datetime
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * @param datetime $date
     */
    public function setDate($date)
    {
        $this->date = $date;
    }

    /**
     * @return mixed
     */
    public function getUserP()
    {
        return $this->UserP;
    }

    /**
     * @param mixed $UserP
     */
    public function setUserP($UserP)
    {
        $this->UserP = $UserP;
    }

    /**
     * @return mixed
     */
    public function getUserR()
    {
        return $this->UserR;
    }

    /**
     * @param mixed $UserR
     */
    public function setUserR($UserR)
    {
        $this->UserR = $UserR;
    }

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

}


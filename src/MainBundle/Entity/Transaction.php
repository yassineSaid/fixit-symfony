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
}


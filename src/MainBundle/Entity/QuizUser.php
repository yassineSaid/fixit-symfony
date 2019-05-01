<?php

namespace MainBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * QuizUser
 *
 * @ORM\Table(name="quiz_user")
 * @ORM\Entity(repositoryClass="MainBundle\Repository\QuizUserRepository")
 */
class QuizUser
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
     * @return mixed
     */
    public function getIdUser()
    {
        return $this->idUser;
    }

    /**
     * @param mixed $idUser
     */
    public function setIdUser($idUser)
    {
        $this->idUser = $idUser;
    }

    /**
     * @return int
     */
    public function getIdQuiz()
    {
        return $this->idQuiz;
    }

    /**
     * @param int $idQuiz
     */
    public function setIdQuiz($idQuiz)
    {
        $this->idQuiz = $idQuiz;
    }

    /**
     * @return int
     */
    public function getTentative()
    {
        return $this->tentative;
    }

    /**
     * @param int $tentative
     */
    public function setTentative($tentative)
    {
        $this->tentative = $tentative;
    }
    /**
     * @var integer
     *
     * @ORM\Column(name="idQuiz", type="integer")
     */
    private $idQuiz;
    /**
 * @var integer
 *
 * @ORM\Column(name="tentative", type="integer")
 */
    private $tentative;

    /**
     * @ORM\ManyToOne(targetEntity="User")
     * @ORM\JoinColumn(name="idUser", referencedColumnName="id")
     */
    private $idUser;


    /**
     * Get idQuiz
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }
}


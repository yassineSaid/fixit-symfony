<?php

namespace MainBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * LikeDislike
 *
 * @ORM\Table(name="like_dislike")
 * @ORM\Entity(repositoryClass="MainBundle\Repository\LikeDislikeRepository")
 */
class LikeDislike
{


    /**
     * @ORM\ManyToOne(targetEntity="User")
     * @ORM\JoinColumn(name="userlike", referencedColumnName="id")
     * @ORM\Id
     */
    private $userlike;

    /**
     * @ORM\ManyToOne(targetEntity="User")
     * @ORM\JoinColumn(name="userliked", referencedColumnName="id")
     * @ORM\Id
     */
    private $userliked;

    /**
     * @var int
     *
     * @ORM\Column(name="lidis", type="integer")
     */
    private $lidis;


    /**
     * Set lidis
     *
     * @param integer $lidis
     *
     * @return LikeDislike
     */
    public function setLidis($lidis)
    {
        $this->lidis = $lidis;

        return $this;
    }

    /**
     * Get lidis
     *
     * @return int
     */
    public function getLidis()
    {
        return $this->lidis;
    }

    /**
     * @return mixed
     */
    public function getUserlike()
    {
        return $this->userlike;
    }

    /**
     * @param mixed $userlike
     */
    public function setUserlike($userlike)
    {
        $this->userlike = $userlike;
    }

    /**
     * @return mixed
     */
    public function getUserliked()
    {
        return $this->userliked;
    }

    /**
     * @param mixed $userliked
     */
    public function setUserliked($userliked)
    {
        $this->userliked = $userliked;
    }


}


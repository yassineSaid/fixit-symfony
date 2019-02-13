<?php

namespace MainBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ServiceUser
 *
 * @ORM\Table(name="service_user")
 * @ORM\Entity(repositoryClass="MainBundle\Repository\ServiceUserRepository")
 */
class ServiceUser
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
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }
}


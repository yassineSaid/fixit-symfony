<?php

namespace MainBundle\Repository;

/**
 * ReclamationRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class ReclamationRepository extends \Doctrine\ORM\EntityRepository
{
    public function findReclamation($idUser)
    {
        $query=$this->getEntityManager()
            ->createQuery("SELECT r FROM MainBundle:Reclamation r where r.user=:id")
            ->setParameter('id',$idUser);
        return $query->getResult();
    }
}

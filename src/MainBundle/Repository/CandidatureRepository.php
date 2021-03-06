<?php

namespace MainBundle\Repository;

/**
 * CandidatureRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class CandidatureRepository extends \Doctrine\ORM\EntityRepository
{
    public function findCandidature($idUser)
    {
        $query=$this->getEntityManager()
            ->createQuery("SELECT c FROM MainBundle:Candidature c where c.User=:id")
            ->setParameter('id',$idUser);
        return $query->getResult();
    }
    public function deleteCandidature($id)
    {
        $query=$this->getEntityManager()
            ->createQuery("DELETE c FROM MainBundle:Candidature c where c.id=:id")
            ->setParameter('id',$id);
        return $query->getResult();
    }
}

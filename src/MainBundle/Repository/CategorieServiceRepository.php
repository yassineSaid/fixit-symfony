<?php

namespace MainBundle\Repository;

/**
 * CategorieServiceRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class CategorieServiceRepository extends \Doctrine\ORM\EntityRepository
{
    public function recherche()
    {
        $query=$this->getEntityManager()->createQuery("SELECT m from MainBundle:CategorieService m where m.nom like :nom")->setParameter('nom','%'.$_GET['search'].'%');
        return $query->getResult();

    }
}

<?php

namespace MainBundle\Repository;

/**
 * ServiceRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class ServiceRepository extends \Doctrine\ORM\EntityRepository
{
    public function groupByCat()
    {
        $query=$this->getEntityManager()->createQuery("SELECT m from MainBundle:Service m group by m.CategorieService");
        return $query->getResult();

    }
    public function lister()
    {
        $query=$this->getEntityManager()->createQuery("SELECT m from MainBundle:Service m where m.CategorieService=:id")->setParameter('id',$_GET['id']);
        return $query->getResult();

    }
    public function afficherBack()
    {
        $query=$this->getEntityManager()->createQuery("SELECT m from MainBundle:Service m where m.visible=:show")->setParameter('show',1);
        return $query->getResult();

    }
    public function nbrByCat()
    {
        $query=$this->getEntityManager()->createQuery("SELECT SUM(m.NbrProviders),p.id from MainBundle:Service m,MainBundle:CategorieService p where m.CategorieService=p.id group by p.id ");
        return $query->getResult();
    }


}

<?php

namespace MainBundle\Repository;


/**
 * ServiceUserRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class ServiceUserRepository extends \Doctrine\ORM\EntityRepository
{
    public function findServiceUserDQL($id)
    {
        $query=$this->getEntityManager()->createQuery("SELECT m from MainBundle:ServiceUser m WHERE m.idUser=:id")->setParameter('id',$id);

        return $query->getResult();

    }
    public function supprimerServiceUserDQL($id,$ids)
    {
        $query=$this->getEntityManager()->createQuery("DELETE  from MainBundle:ServiceUser m WHERE m.idUser=:id and m.idService=:ids")->setParameter('id',$id)->setParameter('ids',$ids);
        $query->execute();
        //return $query->getResult();

    }
    public function moyennePrix()
    {
        $query=$this->getEntityManager()->createQuery("SELECT m.idService,AVG(prix) as moyenne from MainBundle:ServiceUser m group by m.idService");
        return $query->getResult();
    }
}

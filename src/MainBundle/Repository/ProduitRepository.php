<?php

namespace MainBundle\Repository;

/**
 * ProduitRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class ProduitRepository extends \Doctrine\ORM\EntityRepository
{
    public function mesProduitsDQL($id)
    {

        $query=$this->getEntityManager()->createQuery("SELECT p FROM MainBundle:Produit p where p.user = :id ");
        $query->setParameter('id',$id);


        return $query->getResult();
    }
    public function triNomASC()
    {
        $query=$this->getEntityManager()->createQuery("SELECT p FROM MainBundle:Produit p ORDER BY p.nom ");
        return $query->getResult();
    }
    public function triPrixASC()
    {
        $query=$this->getEntityManager()->createQuery("SELECT p FROM MainBundle:Produit p ORDER BY p.prix ");
        return $query->getResult();
    }
    public function triNomDSC()
    {
        $query=$this->getEntityManager()->createQuery("SELECT o FROM MainBundle:Produit p ORDER BY p.nom DESC");
        return $query->getResult();
    }
    public function triPrixDSC()
    {
        $query=$this->getEntityManager()->createQuery("SELECT o FROM MainBundle:Produit p ORDER BY p.prix DESC");
        return $query->getResult();
    }
    public function listMeilleursProduits($solde)
    {
        $query=$this->getEntityManager()->createQuery(
            "SELECT p FROM MainBundle:Produit p WHERE p.prix<=:solde ORDER BY p.prix DESC")->setMaxResults(3);
        $query->setParameter(":solde",$solde);
        return $query->getResult();
    }

    public function SuppDQL($id)
    {

        $query=$this->getEntityManager()->createQuery("DELETE p FROM MainBundle:Produit p where p.CategorieProduit = :id ");
        $query->setParameter('id',$id);
        return $query->getResult();
    }
    public function RechercherDQL($id)
    {

        $query=$this->getEntityManager()->createQuery("SELECT p.id FROM MainBundle:Produit p where p.CategorieProduit = :id ");
        $query->setParameter('id',$id);
        return $query->getResult();
    }

    public function ListeProduitsDQL($user)
    {

        $query=$this->getEntityManager()->createQuery("Select DISTINCT p from MainBundle:Produit p where p.user not in (select pp.user from MainBundle:Produit pp WHERE pp.user= :user) ");
        $query->setParameter('user',$user);
        return $query->getResult();
    }

}

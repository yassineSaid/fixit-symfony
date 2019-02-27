<?php

namespace BackBundle\Controller;

use MainBundle\Entity\Avis;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class AvisBackController extends Controller
{
    public function AvisStatisticsAction()
    {
        $em=$this->getDoctrine()->getManager();
        $nbrnon=$em->getRepository(Avis::class)->findSatisfactionCountsNon();
        var_dump(intval($nbrnon[0][1]));
        $nbrmoy=$em->getRepository(Avis::class)->findSatisfactionCountsMoy();
        $nbrtot=$em->getRepository(Avis::class)->findSatisfactionCountsTot();
        $avg=$em->getRepository(Avis::class)->findMoyenneAvis();
        return $this->render('@Back/Avis/affichageAvis.html.twig',array("nbrnon"=>intval($nbrnon[0][1]),"nbrmoy"=>intval($nbrmoy[0][1]),"nbrtot"=>intval($nbrtot[0][1]),"avg"=>intval($avg[0][1])));

    }
}

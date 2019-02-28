<?php

namespace GrapheBundle\Controller;

use CMEN\GoogleChartsBundle\GoogleCharts\Charts\PieChart;
use MainBundle\Entity\Annonce;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        $pieChart = new stickChart();
        $em = $this->getDoctrine();
        $nbrDem = sizeof($em->getRepository(Annonce::class)->findByType('demande'));

        $nbrOffre = sizeof($em->getRepository(Annonce::class)->findByType('offre'));
        $data = array();
        $stat = ['type', 'nbEtudiant'];
        $nb = ($nbrDem * 100) /($nbrDem+$nbrOffre);
        array_push($data, $stat);
        $stat = array();
        array_push($stat, 'Demandes', ($nbrDem * 100) /($nbrDem+$nbrOffre));
        $stat = ['Demandes', $nb];
        array_push($data, $stat);
        $stat = array();
        array_push($stat, 'Offres', ($nbrOffre * 100) /($nbrDem+$nbrOffre));
        $nb = ($nbrOffre * 100) /($nbrDem+$nbrOffre);
        $stat = ['Offres', $nb];
        array_push($data, $stat);

        $pieChart->getData()->setArrayToDataTable(
            $data
        );
        $pieChart->getOptions()->setTitle('Pourcentages des demandes par offre');
        $pieChart->getOptions()->setHeight(500);
        $pieChart->getOptions()->setWidth(900);
        $pieChart->getOptions()->getTitleTextStyle()->setBold(true);
        $pieChart->getOptions()->getTitleTextStyle()->setColor('#009900');
        $pieChart->getOptions()->getTitleTextStyle()->setItalic(true);
        $pieChart->getOptions()->getTitleTextStyle()->setFontName('Arial');
        $pieChart->getOptions()->getTitleTextStyle()->setFontSize(20);
        return $this->render('@Graphe\Default\index.html.twig', array('piechart' => $pieChart));
    }


}

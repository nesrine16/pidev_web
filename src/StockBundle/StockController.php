<?php

namespace trackBundle\Controller;


use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use trackBundle\Entity\Article;
use trackBundle\Entity\Palette;

class StockController extends Controller
{

 public function showStockAction(){
     $entityManager = $this->getDoctrine()->getManager();

     $query = $entityManager->createQuery(
         'SELECT  p.numLot ,a.refArticle ,a.designation
                ,a.seuilMin, a.seuilMax, SUM(p.qte) u
                FROM  trackBundle:Article a ,trackBundle:Palette p 
                WHERE a.refArticle=p.refArticle
                GROUP BY a.refArticle'


     );


     $stocks = $query->getResult();


     dump($stocks);
     return $this->render('@track/Article/Stock.html.twig', array(
         'stocks' => $stocks
     ));






 }

 public function StatistiquesAction(){
     $entityManager = $this->getDoctrine()->getManager();

     $query = $entityManager->createQuery(
         'SELECT a.designation,p.qte 
          FROM trackBundle:Article a ,trackBundle:Palette p 
          WHERE a.refArticle=p.refArticle 
          ORDER BY  p.qte DESC'


     );
     $stats= $query->getResult();
     dump($stats);
     return $this->render('@track/Stock/Statistiques.html.twig', array(
         'stats' => $stats
     ));
 }



}

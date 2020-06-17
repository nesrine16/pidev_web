<?php

namespace trackBundle\Controller;

use CMEN\GoogleChartsBundle\GoogleCharts\Charts\PieChart;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class StatsController extends Controller
{




    public function StatistiquesAction()
    {

        $entityManager = $this->getDoctrine()->getManager();

        $query = $entityManager->createQuery(
            'SELECT a.designation,p.qte 
          FROM trackBundle:Article a ,trackBundle:Palette p 
          WHERE a.refArticle=p.refArticle 
          ORDER BY  p.qte DESC'


        );
        $stats= $query->getResult();

        for ($i=0;$i<count($stats);$i++) {

            $Columnchart = new \CMEN\GoogleChartsBundle\GoogleCharts\Charts\Material\ColumnChart();
            $Columnchart->getData()->setArrayToDataTable([


                ['Article', 'Quantité'],
                ['lait', '500'],

                ['jus','580'],
                ['eau','80'],
                ['guezoz','800'],
                ['zlebia','400'],


            ]);
        }
        $Columnchart->getOptions()->getChart()
            ->setTitle('Sales per week');
        $Columnchart->getOptions()
            ->setBars('vertical')
            ->setHeight(400)
            ->setWidth(400)
            ->setColors(['#0080FF', '#210B61'])
            ->getVAxis()
            ->setFormat('decimal');


        return $this->render('@track/Stock/stat.html.twig', array(
                'piechart' => $Columnchart,
            )

        );
    }



}

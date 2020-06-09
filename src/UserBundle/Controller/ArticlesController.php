<?php

namespace UserBundle\Controller;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use UserBundle\Entity\Famille;
use UserBundle\Repository\ArticleRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use CommandeBundle\Entity\Article;



class ArticlesController extends AbstractController
{
    /**
     * @param ArticleRepository $articleRepository
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function listmyAction(Request $request)
    {

        $codeFamille = $request->query->get('famille');
        if($codeFamille != ''){
            $query = $this->getDoctrine()->getRepository(Article::class)->findBy(array('famille'=>$codeFamille));
        }
        else{
            $query = $this->getDoctrine()->getRepository(Article::class)->findAll();
        }

        $articles = $this->get('knp_paginator')->paginate(
            $query, /* query NOT result */
            $request->query->getInt('page', 1), /*page number*/
            3 /*limit per page*/
        );

        $familles = $this->getDoctrine()->getRepository(Famille::class)->findAll();
        return $this->render("@User/articles/affiche.html.twig", array(
            "articles" => $articles,
            'familles'=> $familles
        ));
    }
    /*
     * Fonction rechercher mobile
     */
    public function recherFamilleAction($famille)

    {
        $entityManager = $this->getDoctrine()->getManager();

        $listarticle=$entityManager->createQuery(
          /*  "SELECT  a
            FROM UserBundle:Article a
            Left JOIN UserBundle:Famille f
            WITH a.Famille = f.codeFamille
            where f.nomFamille = nomf "
        )*/

            "select Famille.nomFamille from Article
             inner join famille on Famille.codeFamille=article.famille ");




        $serializer = new Serializer([new ObjectNormalizer()]);
        $formatted = $serializer->normalize($listarticle);
        return new JsonResponse($formatted);
    }

    public function testAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $rep=$em->getRepository("CommandeBundle:Article")->findAll();
        $serializer = new Serializer([new ObjectNormalizer()]);
        $formatted = $serializer->normalize($rep);
        return new JsonResponse($formatted);
    }

}

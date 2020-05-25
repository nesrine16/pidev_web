<?php

namespace CommandeBundle\Controller;

use CommandeBundle\Entity\Article;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use UserBundle\Entity\Fournisseur;

class ArticlesController extends Controller
{


    public function showArticleAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

       // $articles = $em->getRepository(Article::class)->findAll();

        $dql=" SELECT p FROM CommandeBundle:Article p";
        $query= $em->createQuery($dql);

        $paginator = $this->get('knp_paginator');

        $pagination = $paginator->paginate(
            $query, /* query NOT result */
            $request->query->getInt('page', 1),
            $request->query->getInt('limit', 3)

        );

        return $this->render('@Commande/Article/showArticle.html.twig', array(



              "articles" => $pagination

        ));
    }







}
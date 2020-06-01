<?php

namespace trackBundle\Controller;

use FamilleBundle\Entity\Famille;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use trackBundle\Entity\Article;
use trackBundle\Form\ArticleType;
use Symfony\Component\HttpFoundation\Request;


class ArticleController extends Controller
{


    public function ajoutArticleAction(Request $request)
    {

        $article = new Article();
        $form = $this->createForm(ArticleType::class, $article);
        $form->handleRequest($request);

        if($form->isSubmitted()){

            $famille = $article->getFamille();
            $fournisseur = $article->getFournisseur();
            $em = $this->getDoctrine()->getManager();
            $article->setFamille($famille);
            $article->setFournisseur($fournisseur);
            $em->persist($article);
            $em->flush();

           return $this->redirectToRoute("show_article");
        }
        ///
        return $this->render("@track/Article/addArticle.html.twig", array(
            'form' => $form->createView()
        ));

    }

    public function showArticleAction()
    {
        //create our entity manager: get the service doctrine
        $em = $this->getDoctrine();
        //repository help you fetch (read) entities of a certain class.
        $repository = $em->getRepository(Article::class);
        //find *all* 'Projet' objects
        $articles = $repository->findAll();
        //render a template with the list of objects
        return $this->render('@track/Article/nihel.html.twig', array(
            'articles' => $articles
        ));
    }

    public function RemoveArticleAction(Request $request)
    {

        $ref=$request->get('ref_article');
        $em=$this->getDoctrine()->getManager();
        $article=$em->getRepository("trackBundle:Article")->find($ref);
        $em->remove($article);
        $em->flush();

        return $this->redirectToRoute("show_Article");
    }

    public function updateArticleAction(Request $request){
        $ref=$request->get('ref_article');
        $em=$this->getDoctrine()->getManager();
        $article=$em->getRepository("trackBundle:Article")->find($ref);
        $designation=$article->getDesignation();


        $form=$this->createForm(ArticleType::class,$article);
        $form->handleRequest($request);
        if($form->isSubmitted()){


            $em->persist($article);
            $em->flush();
            return $this->redirectToRoute("show_Article");
        }
        return $this->render("@track/Article/updateArticle.html.twig",array(
            'form'=>$form->createView(),'article'=>$article,'designation'=>$designation ));
    }




}

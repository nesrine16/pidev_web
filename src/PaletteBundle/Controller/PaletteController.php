<?php

namespace PaletteBundle\Controller;

use CommandeBundle\Entity\Commande;
use CommandeBundle\Entity\Lignecommande;
use PaletteBundle\Entity\Article;
use PaletteBundle\Entity\Palette;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use UserBundle\Form\FournisseurType;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
/**
 * Palette controller.
 *
 */
class PaletteController extends Controller
{
    /**
     * Lists all palette entities.
     *
     */
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        //$palettes = $em->getRepository('PaletteBundle:Palette')->findAll();
        $dql=" SELECT p FROM PaletteBundle:Palette p";
        $query= $em->createQuery($dql);
        $paginator = $this->get('knp_paginator');

        $pagination = $paginator->paginate(
            $query, /* query NOT result */
            $request->query->getInt('page', 1),
            $request->query->getInt('limit', 2)

        );

        return $this->render('palette/index.html.twig', array(

            "pagination" => $pagination
        ));
    }

    /**
     * Creates a new palette entity.
     *
     */
    public function newAction(Request $request)
    {
        $palette = new Palette();
        $form = $this->createForm('PaletteBundle\Form\PaletteType', $palette);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($palette);
            $em->flush();

            return $this->redirectToRoute('palette_index');
        }

        return $this->render('palette/new.html.twig', array(
            'palette' => $palette,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a palette entity.
     *
     */
    public function showAction(Palette $palette)
    {
        $deleteForm = $this->createDeleteForm($palette);

        return $this->render('palette/show.html.twig', array(
            'palette' => $palette,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing palette entity.
     *
     */
    public function editAction(Request $request, Palette $palette)
    {


        $form = $this->createForm('PaletteBundle\Form\PaletteType', $palette);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('palette_index');
        }

        return $this->render('palette/edit.html.twig', array(
            'palette' => $palette,
            'form' => $form->createView(),

        ));
    }




    public function deleteAction(Request $request)
    {

        $id=$request->get('numLot');
        $em=$this->getDoctrine()->getManager();
        $palette=$em->getRepository("PaletteBundle:Palette")->find($id);
        $em->remove($palette);
        $em->flush();
        return $this->redirectToRoute('palette_index');
    }


      public function allAction()
      {
          $em= $this->getDoctrine()->getManager();

          // $palettes= $this->getDoctrine()->getManager()->getRepository('PaletteBundle:Palette')->findAll();
          $dql="  SELECT IDENTITY(P.refArticle), P.numLot,P.qte, P.dateExpiration, IDENTITY(P.codeemp) from PaletteBundle:Palette P, PaletteBundle:Article A, PaletteBundle:Emplacement E   WHERE P.refArticle=A.refArticle and E.codeemp=P.codeemp";
          $query= $em->createQuery($dql);
         $res= $query->getResult();
          for ($i=0;$i<count($res);$i++)
          {
              $res[$i]['dateExpiration']=$res[$i]['dateExpiration']->format('Y-m-d');
          }
          $serializer=new Serializer([new ObjectNormalizer()]);
          $formatted = $serializer->normalize($res);
          return new JsonResponse($formatted);

      }


      public function findAction($num)
      {

          $palettes= $this->getDoctrine()->getManager()->getRepository('PaletteBundle:Palette')->find($num);
          $serializer=new Serializer([new ObjectNormalizer()]);
          $formatted = $serializer->normalize($palettes);
          return new JsonResponse($formatted);
      }

      public function newpAction(Request $request,$ref,$code) {
          $em = $this->getDoctrine()->getManager();
         // $article = new Article();
         // $article->setRefArticle($request->get('refArticle'));
          $article= $em->getRepository('PaletteBundle:Article')->find($ref);
          $codee= $em->getRepository('PaletteBundle:Emplacement')->find($code);


          $palette= new Palette();
          $palette->setQte($request->get('qte'));
          $palette->setRefArticle( $article);
          $palette->setCodeemp($codee);

          //$date=();
          $palette->setDateExpiration(new \DateTime($request->get('dateExpiration')));

          $em->persist($palette);
          $em->flush();
          $serializer=new Serializer([new ObjectNormalizer()]);
          $formatted = $serializer->normalize($palette);
          return new JsonResponse($formatted);
      }


    public function articleAction()
    {
        $em= $this->getDoctrine()->getManager();
        $dql=" SELECT A FROM PaletteBundle:Article A ";

        $query= $em->createQuery($dql);

       //dump($query->getResult());die();

        $serializer=new Serializer([new ObjectNormalizer()]);
        $formatted = $serializer->normalize($query->getResult());
        return new JsonResponse($formatted);

    }

    public function empAction()
    {

        $em= $this->getDoctrine()->getManager();
        $dql=" SELECT A.codeemp FROM PaletteBundle:Emplacement A ";

        $query= $em->createQuery($dql);

        //dump($query->getResult());die();

        $serializer=new Serializer([new ObjectNormalizer()]);
        $formatted = $serializer->normalize($query->getResult());
        return new JsonResponse($formatted);

    }

    public function updatePAction(Request $request, $num,$code,$ref)
    {
        $em = $this->getDoctrine()->getManager();
        $palette= $em->getRepository('PaletteBundle:Palette')->find($num);

        $article= $em->getRepository('PaletteBundle:Article')->find($ref);
        $codee= $em->getRepository('PaletteBundle:Emplacement')->find($code);
        $palette->setQte($request->get('qte'));
        $palette->setRefArticle( $article);
        $palette->setCodeemp($codee);

        $palette->setDateExpiration(new \DateTime($request->get('dateExpiration')));

        $em->flush();
        $serializer=new Serializer([new ObjectNormalizer()]);
        $formatted = $serializer->normalize( $palette);
        return new JsonResponse($formatted);

    }

    public function supprimerPaletteAction(Request $request,$num)
    {
        $em=$this->getDoctrine()->getManager();
        $palette= $em->getRepository('PaletteBundle:Palette')->find($num);
        $em->remove($palette);
        $em->flush();


        $serializer=new Serializer([new ObjectNormalizer()]);
        $formatted = $serializer->normalize( $palette);
        return new JsonResponse($formatted);
    }





}

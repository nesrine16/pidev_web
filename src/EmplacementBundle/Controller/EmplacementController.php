<?php

namespace EmplacementBundle\Controller;

use EmplacementBundle\Entity\Allee;
use EmplacementBundle\Entity\Emplacement;
use FamilleBundle\Entity\Famille;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;


class EmplacementController extends Controller
{
    public function affichEmpAction()
    {
        $em = $this->getDoctrine()->getManager();
        $emp =$em->getRepository("EmplacementBundle:Emplacement")->findAll();

        return $this->render('@Emplacement/Emplacement/test.html.twig',array('emp'=>$emp));
    }



    public function allEmpAction()
    {
        $all = $this->getDoctrine()->getManager()
            ->getRepository(Emplacement::class)->findAll();
        $ser = new Serializer([new ObjectNormalizer()]);
        $formated = $ser->normalize($all);
        return new JsonResponse($formated);

    }

    public function SearchByCodeAction(\Symfony\Component\HttpFoundation\Request $request)
    {

        $code=$request->get('codeEmp');
        $em = $this->getDoctrine()->getManager();
        $aa = $em->getRepository('EmplacementBundle:Emplacement')->findByCodeEmp($code);
        $ser = new Serializer([new ObjectNormalizer()]);
        $formated = $ser->normalize($aa);



        return new JsonResponse($formated);

    }


    public function SearchByEtatAction(\Symfony\Component\HttpFoundation\Request $request)
    {

        $code=$request->get('etat');
        $em = $this->getDoctrine()->getManager();
        $aa = $em->getRepository('EmplacementBundle:Emplacement')->findByEtat($code);
        $ser = new Serializer([new ObjectNormalizer()]);
        $formated = $ser->normalize($aa);



        return new JsonResponse($formated);

    }

    public function AffecterFam(\Symfony\Component\HttpFoundation\Request $request)
    {

        $code=$request->get('etat');
        $em = $this->getDoctrine()->getManager();
        $aa = $em->getRepository('EmplacementBundle:Emplacement')->findByEtat($code);

        $ser = new Serializer([new ObjectNormalizer()]);
        $formated = $ser->normalize($aa);



        return new JsonResponse($formated);

    }

    public function updateEmpAction(\Symfony\Component\HttpFoundation\ Request $request ,$fam,$allee)
    {
        $em = $this->getDoctrine()->getManager();


        $famille = $em->getRepository('FamilleBundle:Famille')->find($fam);


        $emp = $em->getRepository('EmplacementBundle:Emplacement')->find($allee);
        $emp->setFamille($famille);
        $emp->setEtat("Réservé");
        //dump($emp); die();

        $em->flush();

        $ser = new Serializer([new ObjectNormalizer()]);

        $formated = $ser->normalize($emp);



        return new JsonResponse($formated);
    }






}

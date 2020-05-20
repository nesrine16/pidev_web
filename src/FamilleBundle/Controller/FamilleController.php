<?php

namespace FamilleBundle\Controller;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\FormTypeInterface;

use FamilleBundle\Entity\Famille;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

class FamilleController extends AbstractController

{
    public  function addAction(Request $request){

        $fam = new Famille();
        $form = $this->createFormBuilder($fam)
        ->add('nomFamille',TextType::class,array(
            'attr'=>array('class'=>'form-control'),

        ))
            ->getForm();
        $form->handleRequest($request);
        if($form->isSubmitted()&& $form->isValid()){
            $em=$this->getDoctrine()->getManager();
            $em->persist($fam);
            $em->flush();
        }
        $repository = $this->getDoctrine()->getRepository(Famille::class);
        $fams=$repository->findAll();
        return $this->render('@Famille/famille/add.html.twig',['form'=>$form->createView(),'fams'=>$fams]
        );

    }

    public  function  delFamilleAction ($codeFamille=null){
        {
            $em = $this->getDoctrine()->getManager();

            $Categorie = $em->getRepository('FamilleBundle:Famille')->find($codeFamille);
            $em->remove($Categorie);
            $em->flush();


            return $this->redirectToRoute('addfamille');
        }


    }



    public function allFamilleAction()
{
    $all = $this->getDoctrine()->getManager()
        ->getRepository('FamilleBundle:Famille')->findAll();
    $ser = new Serializer([new ObjectNormalizer()]);
    $formated = $ser->normalize($all);

    return new JsonResponse($formated);

}



    public function SearchFamAction(\Symfony\Component\HttpFoundation\Request $request)
    {

        $code=$request->get('nomFamille');
        $em = $this->getDoctrine()->getManager();
        $aa = $em->getRepository('FamilleBundle:Famille')->findByNomFamille($code);
        $ser = new Serializer([new ObjectNormalizer()]);
        $formated = $ser->normalize($aa);


        return new JsonResponse($formated);

    }

}

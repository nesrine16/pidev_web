<?php


namespace EmplacementBundle\ControllerI;


use EmplacementBundle\Entity\Image;
use EmplacementBundle\Form\ImageType;
use http\Env\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class ImageController extends Controller
{
    public function uploadAction(\Symfony\Component\HttpFoundation\Request $request)
    {
        $image =new Image( );
        $form = $this->createForm(ImageType::class, $image);
        $form->handleRequest($request);


        $em = $this->getDoctrine()->getManager();
        $em->persist($image);
        $em->flush();

    }

}
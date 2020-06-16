<?php

namespace EmplacementBundle\Controller;

use EmplacementBundle\EmplacementBundle;
use EmplacementBundle\Entity\Allee;
use EmplacementBundle\Entity\Emplacement;
use EmplacementBundle\Entity\Image;
use EmplacementBundle\Entity\Travee;
use EmplacementBundle\Form\AlleeType;
use EmplacementBundle\Form\ImageType;
use GuzzleHttp\Psr7\UploadedFile;
use http\Env\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

class AlleeController extends Controller
{

    public function ajoutAlleeAction(\Symfony\Component\HttpFoundation\Request $request)
    {
        $allee = new Allee();
        $image =new Image();
        $form = $this->createForm(AlleeType::class, $allee);
        $form->handleRequest($request);

        $form2 = $this->createForm(ImageType::class, $image);
        $form2->handleRequest($request);

        $em = $this->getDoctrine()->getManager();
//


        if ($form->isSubmitted() && $form->isValid()  )
        {

          //  dump(  $form["ligne"]->getData()); die();
            $object = $this->getDoctrine()->getRepository('EmplacementBundle:Allee')->findByLigne($allee->getLigne());
          //  dump($object); die();
            /**
            * @var \Symfony\Component\HttpFoundation\File\UploadedFile $file
             */

            $file= $form2['image']->getData();
            $fileName =md5(uniqid()).'.'.$file->guessExtension();
            $file->move($this->getParameter('images_directory'),$fileName);
            $image->setImage($fileName);
            $allee->setImage($fileName);

            $em->persist($image);


            $em->persist($allee);
                $em->flush();
                $nb = $allee->getNbTrav();
                $niv = $allee->getNiv();
                $ligne = $allee->getLigne();
              //  $id = $em->getRepository(Allee::class)->find($allee->getId());
                $id = $allee->getId();

                for ($i = 1; $i <= $nb; $i++) {
                    for ($j = 1; $j <= $niv; $j++) {
                        $travee = new Travee();
                        $emp = new Emplacement();
                        $travee->setNumTrav($i);
                        $m = $this->getDoctrine()->getManager();
                        $idA = $m->getRepository(Allee::class)->find($id);


                        $emp->setAllee($idA);
                        $emp->setIntitule("Allée " . $ligne . " Travée 0" . $i . " Niveau 0" . $j);
                        $emp->setCodeEmp($ligne . "-0" . $i . " -0" . $j);
                        $emp->setEtat("Disponible");
                        $travee->setAllee($idA);
                        $m->persist($emp);
                        $m->persist($travee);
                        $m->flush();

                        $idEmp =$emp->getId();
                        $idE = $m->getRepository(Emplacement::class)->find($idEmp);
                        $travee->setIdEmp($idE);
                        $m->persist($travee);
                        $m->flush();

                    }
                }
            }


            $aa = $em->getRepository("EmplacementBundle:Allee")->findAll();

            return $this->render('@Emplacement/Emplacement/AjoutAllee.html.twig', ['form' => $form->createView(), 'aa' => $aa,'aaa'=>$allee,
                'form2' => $form2->createView()] );


    }

    public function affichAlleeAction(\Symfony\Component\HttpFoundation\Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        //$allee = $em->getRepository("EmplacementBundle:Allee")->findAll();

        $dql=" SELECT p FROM EmplacementBundle:Allee p";
        $query= $em->createQuery($dql);

        $paginator = $this->get('knp_paginator');

        $pagination = $paginator->paginate(
            $query, /* query NOT result */
            $request->query->getInt('page', 1),
            $request->query->getInt('limit', 3));

        return $this->render('@Emplacement/Emplacement/AffichAllee.html.twig', array('allee' => $pagination));

    }


    public function delAlleeAction($id)
    {
        {
            $aa = new Allee();
            $em = $this->getDoctrine()->getManager();

            $aa = $em->getRepository('EmplacementBundle:Allee')->find($id);
            $em->remove($aa);
            $em->flush();


            $query1 = $em->createQuery('DELETE FROM EmplacementBundle:Emplacement c WHERE c.allee IS NULL');
            $query1->execute();

            $query1 = $em->createQuery('DELETE FROM EmplacementBundle:Emplacement c WHERE c.allee IS NULL');
            $query1->execute();

            $query2 = $em->createQuery('DELETE FROM EmplacementBundle:Travee c WHERE c.allee IS NULL');
            $query2->execute();


            return $this->redirectToRoute('allee_ajout');


        }
    }


    public function allAction()
    {
        $all = $this->getDoctrine()->getManager()
            ->getRepository('EmplacementBundle:Allee')->findAll();
        $ser = new Serializer([new ObjectNormalizer()]);
        $formated = $ser->normalize($all);

        return new JsonResponse($formated);

    }


    public function addAction(\Symfony\Component\HttpFoundation\Request $request)
    {
        $allee = new Allee();
        $em = $this->getDoctrine()->getManager();
        $allee->setLigne($request->get('ligne'));
        $allee->setNbTrav($request->get('nbTrav'));
        $allee->setNiv($request->get('niv'));

        $em->persist($allee);
        $em->flush();
        $ser = new Serializer([new ObjectNormalizer()]);
        $formated = $ser->normalize($allee);

        $nb = $request->get('nbTrav');
        $niv = $request->get('niv');
        $ligne = $request->get('ligne');
        $id = $em->getRepository(Allee::class)->find($allee->getId());


        for ($i = 1; $i <=$nb; $i++) {
            for ($j = 1; $j <= $niv; $j++) {
                $travee = new Travee();
                $emp = new Emplacement();
                $travee->setNumTrav($i);
                $m = $this->getDoctrine()->getManager();
                $idA = $m->getRepository(Allee::class)->find($id);

                $emp->setAllee($idA);
                $emp->setIntitule("Allée " . $ligne . " Travée 0" . $i . " Niveau 0" . $j);
                $emp->setCodeEmp($ligne . "-0" . $i . " -0" . $j);
                $emp->setEtat("Disponible");
                $travee->setAllee($idA);
                $m->persist($emp);
                $m->persist($travee);
                $m->flush();

                $idEmp =$emp->getId();
                $idE = $m->getRepository(Emplacement::class)->find($idEmp);
                $travee->setIdEmp($idE);
                $m->persist($travee);
                $m->flush();

            }

        }
        return new JsonResponse($formated);
    }


    public function updateAlleeAction(\Symfony\Component\HttpFoundation\Request $request){

        $em = $this->getDoctrine()->getManager();

        $id=$request->get('id');
        $aa = $em->getRepository('EmplacementBundle:Allee')->find($id);
        $tr1=$aa->getNbTrav();


        $form = $this->createForm(AlleeType::class, $aa);
        $form->handleRequest($request);
        $tr2=$aa->getNbTrav();

        $nv1= $aa->getNiv();
        $ligne=$aa->getLigne();

        if($form->isSubmitted()){

            if($tr1<$tr2) {
                $em->persist($aa);
                $nv2 = $aa->getNiv();
                {
                    for ($i = $tr1 + 1; $i <= $aa->getNbTrav(); $i++) {
                        for ($j = 1; $j <= $nv2; $j++) {
                            $travee = new Travee();
                            $emp = new Emplacement();
                            $travee->setNumTrav($i);
                            $m = $this->getDoctrine()->getManager();
                            $idA = $m->getRepository(Allee::class)->find($id);

                            $emp->setAllee($idA);
                            $emp->setIntitule("Allée " . $ligne . " Travée 0" . $i . " Niveau 0" . $j);
                            $emp->setCodeEmp($ligne . "-0" . $i . " -0" . $j);
                            $emp->setEtat("Disponible");
                            $travee->setAllee($idA);

                            $m->persist($emp);
                            $m->persist($travee);
                            $m->flush();

                            $idEmp =$emp->getId();
                            $idE = $m->getRepository(Emplacement::class)->find($idEmp);
                            $travee->setIdEmp($idE);
                            $m->persist($travee);
                            $m->flush();
                        }
                    }
                }
                $em->flush();
            }
            else if($tr1>$tr2) {

                $m = $this->getDoctrine()->getManager();
                $idA = $m->getRepository(Allee::class)->find($id);
                $nn[] = $this->getListTraveeAction(2,302);
                /******************************/
                for ( $i=0;$i<count($nn);$i++ )
                {
                   dump($nn[$i]['allee']);
                   die();

                    $query = $em->createQuery('DELETE FROM EmplacementBundle:Emplacement c WHERE c.id = ?1');

                    $query1 = $em->createQuery('DELETE FROM EmplacementBundle:Travee c WHERE c.idEmp IS NULL');
                    $query1->execute();


                }



            }
                return $this->redirectToRoute("allee_ajout");

        }
        return $this->render('@Emplacement/Emplacement/updateAllee.html.twig', ['form' => $form->createView(), 'aa' => $aa]);

    }
    public function getListTraveeAction($numTrav,$idA)
    {
        $ser = new Serializer([new ObjectNormalizer()]);
        $em = $this->getDoctrine()->getManager();

        $query = $em->createQuery('SELECT u FROM EmplacementBundle:Travee u ,EmplacementBundle:Allee a 
        WHERE a.id = ?1 AND u.numTrav = ?2 and a.id=u.allee');


        $query->setParameter(1, $idA);
        $query->setParameter(2, $numTrav);
        $uu = $query->getResult();

        $formated = $ser->normalize($uu);


        return new JsonResponse($formated);

    }



    public function updateAction(\Symfony\Component\HttpFoundation\Request $request)
    {

        $id=$request->get('id');
        $n=$request->get('nbTrav');

        $em=$this->getDoctrine()->getManager();
        $aa = $em->getRepository('EmplacementBundle:Allee')->find($id);
        $ligne=$aa->getLigne();
        $tr1=$aa->getNbTrav();

        $aa->setNbTrav($n);

            $em->persist($aa);
            $em->flush();

            $em->persist($aa);
            $nv2 = $aa->getNiv();
            {
                for ($i = $tr1 + 1; $i <= $aa->getNbTrav(); $i++) {
                    for ($j = 1; $j <= $nv2; $j++) {
                        $travee = new Travee();
                        $emp = new Emplacement();
                        $travee->setNumTrav($i);
                        $m = $this->getDoctrine()->getManager();
                        $idA = $m->getRepository(Allee::class)->find($id);

                        $emp->setAllee($idA);
                        $emp->setIntitule("Allée " . $ligne . " Travée 0" . $i . " Niveau 0" . $j);
                        $emp->setCodeEmp($ligne . "-0" . $i . " -0" . $j);
                        $emp->setEtat("Disponible");
                        $travee->setAllee($idA);
                        $m->persist($emp);
                        $m->persist($travee);
                        $m->flush();
                        $idEmp =$emp->getId();
                        $idE = $m->getRepository(Emplacement::class)->find($idEmp);
                        $travee->setIdEmp($idE);
                        $m->persist($travee);
                    }

            }
            $em->flush();
        }

        $ser = new Serializer([new ObjectNormalizer()]);
        $formated = $ser->normalize($aa);

        return new JsonResponse($formated);

    }


    public function deleteAction(\Symfony\Component\HttpFoundation\Request $request)
    {

        $id=$request->get('id');
        $em = $this->getDoctrine()->getManager();

        $aa = $em->getRepository('EmplacementBundle:Allee')->find($id);
        $em->remove($aa);
        $em->flush();


        $query1 = $em->createQuery('DELETE FROM EmplacementBundle:Emplacement c WHERE c.allee IS NULL');
        $query1->execute();

        $query1 = $em->createQuery('DELETE FROM EmplacementBundle:Emplacement c WHERE c.allee IS NULL');
        $query1->execute();

        $query2 = $em->createQuery('DELETE FROM EmplacementBundle:Travee c WHERE c.allee IS NULL');
        $query2->execute();


        $ser = new Serializer([new ObjectNormalizer()]);
        $formated = $ser->normalize($aa);



        return new JsonResponse($formated);

    }


    public function mailAction(){
        //dump($id);die();
        //dump($fournisseur);die();

//        if($request->isMethod('POST')){
        $message = \Swift_Message::newInstance()
            ->setFrom('chaima.besbes2@gmail.com','smart truck')
            ->setTo('chaima.besbes2@gmail.com')
            ->setBody('message');

        $this->get('mailer')->send($message);
        return $this->render('@Emplacement/Emplacement/mail.html.twig');

    }



    public function getAlleeAction($id)
    {
        $all = $this->getDoctrine()->getManager()
            ->getRepository('EmplacementBundle:Allee')->findByLigne($id);
        $ser = new Serializer([new ObjectNormalizer()]);
        $formated = $ser->normalize($all);

        return new JsonResponse($formated);

    }










}

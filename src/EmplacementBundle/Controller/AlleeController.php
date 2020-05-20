<?php

namespace EmplacementBundle\Controller;

use EmplacementBundle\EmplacementBundle;
use EmplacementBundle\Entity\Allee;
use EmplacementBundle\Entity\Emplacement;
use EmplacementBundle\Entity\Travee;
use EmplacementBundle\Form\AlleeType;
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
        $form = $this->createForm(AlleeType::class, $allee);
        $form->handleRequest($request);
        $em = $this->getDoctrine()->getManager();


        if ($form->isSubmitted()) {

            $em->persist($allee);
            $em->flush();
            $nb = $allee->getNbTrav();
            $niv = $allee->getNiv();
            $ligne = $allee->getLigne();
            $id = $em->getRepository(Allee::class)->find($allee->getId());
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
                }

            }

        }
        $aa = $em->getRepository("EmplacementBundle:Allee")->findAll();


        return $this->render('@Emplacement/Emplacement/AjoutAllee.html.twig', ['form' => $form->createView(), 'aa' => $aa]);
    }

    public function affichAlleeAction()
    {
        $em = $this->getDoctrine()->getManager();
        $allee = $em->getRepository("EmplacementBundle:Allee")->findAll();

        return $this->render('@Emplacement/Emplacement/AffichAllee.html.twig', array('allee' => $allee));
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
                        }
                    }
                }
                $em->flush();
            }
            else {



                $query = $em->createQuery(
                    'DELETE  FROM EmplacementBundle:Emplacement e
                    where idAllee in (
                    Select r FROM EmplacementBundle:Emplacement r
                  inner  join EmplacementBundle:Travee t
                    where r.idAllee=t.idAllee and numTrav=$n'  );



                $qb = $em->createQueryBuilder();
                $query = $qb->delete('EmplacementBundle:Emplacement d')
                    ->where('d.idAllee  IN (SELECT d.idAllee FROMEmplacementBundle:Travee  d \
                  INNER JOIN d.EmplacementBundle:Travee a WHERE   a.numTrav = 2)')
                 ;
                $query->execute();



            }
                return $this->redirectToRoute("allee_ajout");

        }
        return $this->render('@Emplacement/Emplacement/updateAllee.html.twig', ['form' => $form->createView(), 'aa' => $aa]);

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


        if($tr1<$n) {
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
                    }
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







}

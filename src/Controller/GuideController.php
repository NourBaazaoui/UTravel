<?php

namespace App\Controller;

use App\Entity\Guide;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;


use App\Form\GuideType;


class GuideController extends AbstractController
{
    /**
     * @Route("/guide", name="guide")
     */
    public function index(): Response
    {
        return $this->render('/guide/index.html.twig', [
            'controller_name' => 'GuideController',
        ]);
    }
    /**
     * @Route("/guide/ajout", name="ajout")
     */
    public function addGuide(Request $request):Response
    {
        $Guide = new Guide();
        $form=$this->createForm(GuideType::class,$Guide);
        if($form->isSubmitted() && $form->isValid()){
            $Guide=$form->getData();
            $em=$this->getDoctrine()->getManager();
            $em->persist($Guide);
            $em->flush();
            return $this->redirectToRoute('List');
        }
        return $this->render('guide/ajout.html.twig',[
            'formA' => $form->createView()
        ]);
    }
    /**
     * @Route("guide/updates/{email}", name="update")
     */
    public function updates(Request $request, $email): Response
    {
        $rep = $this->getDoctrine()->getRepository(Guide::class);
        $Guide = $rep->find($email); // nouvelle instance
        $form = $this->createForm(GuideType::class, $Guide);
        $form->handleRequest($request);
        if ($form->isSubmitted()) {

            $em = $this->getDoctrine()->getManager();
            $em->flush();
            return $this->redirectToRoute('Guidelist');
        }


        return $this->render('guide/updates.html.twig', [
            'formA' => $form->createView(),
        ]);
    }

    /**
     * @Route("/delete/{email}", name="deletes")
     */
    public function deletes($email): Response
    { $rep=$this->getDoctrine()->getRepository(Guide::class);
        $em=$this->getDoctrine()->getManager();
        $Guide=$rep->find($email);
        $em->remove($Guide);
        $em->flush();

        return $this->redirectToRoute('list');

    }
}

<?php

namespace App\Controller;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\UserRepository;
use App\Form\UserType;
use Symfony\Component\HttpFoundation\Request;

class UserController extends AbstractController
{
    /**
     * @Route("/user", name="user")
     */
    public function index(): Response
    {
        return $this->render('user/index.html.twig', [
            'controller_name' => 'UserController',
        ]);
    }
    /**
     * @Route("admin", name="admin")
     */
    public function admin(): Response
    {
        return $this->render('admin/admin.html.twig', [
            'controller_name' => 'UserController',
        ]);
    }
    /**
     * @Route("/user/add", name="adds")
     */
    public function addUser(Request $request):Response
    {
        $User = new User();
        $form=$this->createForm(UserType::class,$User);
        if($form->isSubmitted() && $form->isValid()){
            $User=$form->getData();
            $em=$this->getDoctrine()->getManager();
            $em->persist($User);
            $em->flush();
            return $this->redirectToRoute('UserList');
        }
        return $this->render('user/add.html.twig',[
            'formA' => $form->createView()
        ]);
    }
    /**
     * @Route("user/update/{id}", name="update")
     */
    public function updates(Request $request, $id): Response
    {
        $rep = $this->getDoctrine()->getRepository(User::class);
        $User = $rep->find($id); // nouvelle instance
        $form = $this->createForm(UserType::class, $User);
        $form->handleRequest($request);
        if ($form->isSubmitted()) {

            $em = $this->getDoctrine()->getManager();
            $em->flush();
            return $this->redirectToRoute('Userlist');
        }


        return $this->render('user/update.html.twig', [
            'formA' => $form->createView(),
        ]);
    }

    /**
     * @Route("user/delete/{email}", name="deletes")
     */
    public function deletes($email): Response
    { $rep=$this->getDoctrine()->getRepository(User::class);
        $em=$this->getDoctrine()->getManager();
        $User=$rep->find($email);
        $em->remove($User);
        $em->flush();

        return $this->redirectToRoute('list');

    }

}

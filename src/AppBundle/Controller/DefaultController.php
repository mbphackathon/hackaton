<?php

namespace AppBundle\Controller;

use AppBundle\Entity\User;
use AppBundle\Form\InscriptionUserType;
use AppBundle\Form\UserType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {
        $user = new User();
        $form = $this->createForm(InscriptionUserType::class, $user);
        $oldThumbnail = $user->getThumbnail();
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->updateUser($user, $oldThumbnail);
            return $this->redirect($this->generateUrl('user:profile:view', ['id' => $user->getId()]));
        }


        return $this->render('Login/login.html.twig', ['form' => $form->createView()]);
    }

    /**
     * @Route("/profile/update/{id}", name="profile:update")
     */
    public function profileUpdateAction($id, Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        /** @var User $user */
        $user = $em->getRepository('AppBundle:User')->find($id);
        if(!$user) {
            throw new HttpException('Utilisateur non trouvé!');
        }
        $form = $this->createForm(UserType::class, $user);
        $oldThumbnail = $user->getThumbnail();
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->updateUser($user, $oldThumbnail);
            return $this->redirect($this->generateUrl('user:profile:view',  ['id' => $user->getId()]));
        }

        return $this->render('default/profile-update.html.twig', ['form' => $form->createView(), 'user' => $user]);
    }

    /**
     * @Route("/profile/view/{id}", name="user:profile:view")
     */
    public function profileViewAction($id, Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        /** @var User $user */
        $user = $em->getRepository('AppBundle:User')->find($id);
        if(!$user) {
            throw new HttpException('Utilisateur non trouvé!');
        }

        return $this->render('default/profile-view.html.twig', ['user' => $user]);
    }

    /**
     * @Route("/profile/list", name="user:profile:list")
     */
    public function profileListAction(Request $request)
    {

        $em = $this->getDoctrine()->getManager();
        /** @var User $user */
        $users = $em->getRepository('AppBundle:User')->findAll();
        return $this->render('default/profile-list.html.twig', ['users' => $users]);
    }


    private function updateUser(User $user, $oldThumbnail = null)

    {
        $em = $this->getDoctrine()->getManager();
        /** @var UploadedFile $thumbnail */
        $thumbnail = $user->getThumbnail();
        if($thumbnail instanceof UploadedFile) {
            $fileName = md5(uniqid()).'.'.$thumbnail->guessExtension();

            // Move the file to the directory where brochures are stored
            $thumbnail->move(
                $this->getParameter('thumbnail_directory'),
                $fileName
            );
            $user->setThumbnail($fileName);
        }
        if($oldThumbnail != null && $user->getThumbnail() == null) {
            $user->setThumbnail($oldThumbnail);
        }
        $em->persist($user);
        $em->flush();
        $em->refresh($user);
    }
}

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
        $em = $this->getDoctrine()->getManager();
        $user = new User();
        $form = $this->createForm(InscriptionUserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->updateUser($user);
            return $this->redirect($this->generateUrl('user:profile:view', ['id' => $user->getId()]));
        }


        return $this->render('Login/login.html.twig', ['form' => $form->createView()]);
    }

    /**
     * @Route("/profile/update", name="profile:update")
     */
    public function profileUpdateAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        /** @var User $user */
        $user = $em->getRepository('AppBundle:User')->find($request->get('id'));
        if(!$user) {
            throw new HttpException('Utilisateur non trouvé!');
        }
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->updateUser($user);
            return $this->redirect($this->generateUrl('user:profile:view',  ['id' => $user->getId()]));
        }


        return $this->render('default/profile-update.html.twig', ['form' => $form->createView()]);
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
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->updateUser($user);
            return $this->redirect($this->generateUrl('user:profile:view'));
        }


        return $this->render('default/profile-update.html.twig', ['form' => $form->createView(), '']);
    }

    private function updateUser(User $user)
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
        $em->persist($user);
        $em->flush();
        $em->refresh($user);
    }
}

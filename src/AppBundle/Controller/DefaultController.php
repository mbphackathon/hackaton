<?php

namespace AppBundle\Controller;

use AppBundle\Entity\User;
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
        // replace this example code with whatever you need
        return $this->render('default/index.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.root_dir') . '/..') . DIRECTORY_SEPARATOR,
        ]);
    }

    /**
     * @Route("/profile/update", name="profile:update")
     */
    public function profileUpdateAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $user = $em->getRepository('AppBundle:User')->find($request->get('id'));
        if(!$user) {
            throw new HttpException('Utilisateur non trouvé!');
        }
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
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
            $em->flush();

            return $this->redirect($this->generateUrl('user:profile:view'));
        }


        return $this->render('default/profile-update.html.twig', ['form' => $form->createView(), '']);
    }
}

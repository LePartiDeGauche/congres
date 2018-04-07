<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction()
    {
        $category = $this->getDoctrine()
                         ->getRepository('AppBundle:Category')
                         ->findOneByTitle($this->container->getParameter('category_homepage'));

        return $this->render('default/index.html.twig', array(
            'pageShow' => $this->getDoctrine()
                               ->getRepository('AppBundle:Page')
                               ->findActivePageByCategory($category)
        ));
    }

    /**
     * @Route("/downloads/{filename}", name="downloads")
     */
    public function downloadAction($filename)
    {
        $filename = str_replace('../', '', $filename);
        $filename = __DIR__.'/../../../app/Resources/downloads/'.$filename;
        if (!file_exists($filename)) {
            throw $this->createNotFoundException('Ce fichier n\'existe pas.');
        }

        return new BinaryFileResponse($filename);
    }

    /**
     * @Route("inscription/check-email/{email}", name="custom_user_registration_check_email")
     * Replace default FOSUserBundle check email controller to work even if user does not exist.
     */
    public function customUserRegistrationCheckEmailAction($email)
    {
        $user = new \AppBundle\Entity\User();
        $user->setEmail($email);

        return $this->render('FOSUserBundle:Registration:checkEmail.html.twig', array(
            'user' => $user,
        ));
    }
}

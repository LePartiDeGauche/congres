<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction()
    {
        return $this->render('default/index.html.twig');
    }

    /**
     * @Route("/depot-contribution")
     */
    public function redirectionDepotContributionAction()
    {
        return $this->redirect($this->generateUrl('contribution_submit'));
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

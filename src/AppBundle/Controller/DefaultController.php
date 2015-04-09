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
        return $this->render('default/index.html.twig');
    }

    /**
     * @Route("/commission-votes", name="commission_votes")
     */
    public function commissionVoteAction()
    {
        return $this->render('commissions/commission-votes.html.twig');
    }

    /**
     * @Route("/commission-debats", name="commission_debats")
     */
    public function commissionDebatsAction()
    {
        return $this->render('commissions/commission-debats.html.twig');
    }

    /**
     * @Route("/depot-contribution")
     */
    public function redirectionDepotContributionAction()
    {
        return $this->redirect($this->generateUrl('contribution_submit'));
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

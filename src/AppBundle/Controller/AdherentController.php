<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class AdherentController extends Controller
{
    /**
     * @Route("/mon-compte/profil", name="adherent_profile")
     */
    public function profileAction()
    {
        return $this->render('adherent/profile.html.twig');
    }
}

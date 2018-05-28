<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class CandidatureCallController extends Controller
{
    /**
     * _partial controller that list active candidature call
     */
    public function fragmentListAction()
    {
        $candidatureCalls = $this->getDoctrine()->getManager()
                    ->getRepository('AppBundle:Election\CandidatureCall')
                    ->findAll();
        return $this->render('candidature/_listCandidatureCall.twig.html', array(
            'candidatureCalls' => $candidatureCalls,
        ));
    }
}

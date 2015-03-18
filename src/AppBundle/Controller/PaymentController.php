<?php

namespace AppBundle\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use AppBundle\Entity\Payment\Payment;

/**
 * Payment\Payment controller.
 *
 * @Route("/payment")
 */
class PaymentController extends Controller
{

    /**
     * Online transaction with paybox 
     *
     * @Route("/{id}", name="payment_pay")
     * @Method("GET")
     * @ParamConverter("payment", class="AppBundle:Payment\Payment", options={"id" = "id"})
     */
    public function payAction(Payment $payment)
    {
        $adherent = $this->getUser()->getProfile();

        if ($payment->getStatus() == Payment::STATUS_NEW &&
            $payment->getMethod() == Payment::METHOD_CREDIT_CARD &&
            $payment->getAuthor() == $adherent)
        {

            $cmdid = $payment->getReferenceIdentifierPrefix(). '-' . $payment->getId();
            $paybox = $this->get('lexik_paybox.request_handler');
            $paybox->setParameters(array(
                'PBX_CMD'          => $cmdid, 
                'PBX_DEVISE'       => '978',
                'PBX_PORTEUR'      => $adherent->getEmail(),
                'PBX_RETOUR'       => 'Mt:M;Ref:R;Auto:A;Erreur:E',
                'PBX_TOTAL'        => round(100 * $payment->getAmount()),
                'PBX_TYPEPAIEMENT' => 'CARTE',
                'PBX_TYPECARTE'    => 'CB',
                'PBX_EFFECTUE'     => $this->generateUrl('payment_paybox_return',
                array('status' => 'success'), true),
                'PBX_REFUSE'       => $this->generateUrl('payment_paybox_return',
                array('status' => 'denied'), true),
                'PBX_ANNULE'       => $this->generateUrl('payment_paybox_return',
                array('status' => 'canceled'), true),
                'PBX_ATTENTE'       => $this->generateUrl('payment_paybox_return', array('status' => 'pending'), true),
                'PBX_RUF1'         => 'POST',
                'PBX_REPONDRE_A' => $this->generateUrl('lexik_paybox_ipn', array('time' => time()), true),
            ));

            $payment->setStatus(Payment::STATUS_PENDING);
            return $this->render("payment/pay.html.twig", array(
                'url'  => $paybox->getUrl(),
                'form' => $paybox->getForm()->createView(),
                'payment'      => $payment,
            ));
        }
    }

    /**
     * Online transaction with paybox 
     *
     * @Route("/return/{status}", name="payment_paybox_return")
     *
     */
    public function returnAction($status)
    {
        return $this->render(
            "payment/return.html.twig",
            array(
                'status'     => $status,
                'parameters' => $this->getRequest()->query,
            )
        );
    }

}

<?php
/**
 * Created by PhpStorm.
 * User: Matrix
 * Date: 06.10.14
 * Time: 13:02
 */

namespace Matrix\ServiceBundle\Controller;


use Matrix\ServiceBundle\Entity\CreditCardPayment;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class TestController extends Controller{

    public function testAllAction(){
        $this->testBondPaymentAction();
        $this->testCashPaymentAction();
        $this->testCCPaymentAction();
        $this->testChequePaymentAction();
        return new Response();
    }

    public function testCCPaymentAction(){
        $em = $this->getDoctrine()->getManager();
        $repo = $em->getRepository("MatrixServiceBundle:CreditCardPayment");
        $payment = $repo->findOneBy(array("id" => 1));
        var_dump($payment);
        var_dump($payment->getCurrency());
        var_dump($payment->getMobileUser());
        var_dump($payment->getCustomer());
        return new Response("<body></body>");
    }

    public function testBondPaymentAction(){
        $em = $this->getDoctrine()->getManager();
        $repo = $em->getRepository("MatrixServiceBundle:BondPayment");
        $payment = $repo->findOneBy(array("id" => 1));
        var_dump($payment);
        var_dump($payment->getCurrency());
        var_dump($payment->getMobileUser());
        var_dump($payment->getCustomer());
        return new Response("<body></body>");
    }

    public function testChequePaymentAction(){
        $em = $this->getDoctrine()->getManager();
        $repo = $em->getRepository("MatrixServiceBundle:ChequePayment");
        $payment = $repo->findOneBy(array("id" => 1));
        var_dump($payment);
        var_dump($payment->getCurrency());
        var_dump($payment->getMobileUser());
        var_dump($payment->getCustomer());
        return new Response("<body></body>");
    }

    public function testCashPaymentAction(){
        $em = $this->getDoctrine()->getManager();
        $repo = $em->getRepository("MatrixServiceBundle:CashPayment");
        $payment = $repo->findOneBy(array("id" => 1));
        var_dump($payment);
        var_dump($payment->getCurrency());
        var_dump($payment->getMobileUser());
        var_dump($payment->getCustomer());
        return new Response("<body></body>");
    }

} 
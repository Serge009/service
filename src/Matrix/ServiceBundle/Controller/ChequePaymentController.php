<?php
/**
 * Created by PhpStorm.
 * User: Matrix
 * Date: 20.10.14
 * Time: 10:45
 */

namespace Matrix\ServiceBundle\Controller;


use DateTime;
use Exception;
use Matrix\ServiceBundle\Entity\ChequePayment;
use Matrix\ServiceBundle\Entity\Statuses;
use Matrix\ServiceBundle\Utils\Errors;
use Symfony\Component\HttpFoundation\Request;

class ChequePaymentController extends AppController {

    public function indexAction(Request $request){
        try{
            $data = json_decode($request->request->get('data'));

            if(!$data || !$session = $this->isSessionValid($data->session)){
                return $this->renderError(Errors::INCORRECT_REQUEST);
            }

            return $this->createPayment($data->payments, $session->getDevice()->getUser()->getId());
//            return $this->renderData(array());

        } catch(Exception $e){
            //echo $e->getMessage();
            $this->get('logger')->error($e->getMessage() . ' ' . __FILE__ . ' on line = ' . __LINE__);
            return $this->renderError(Errors::INCORRECT_REQUEST);
        }
    }

    private function createPayment(array $payments, $user){


        $em = $this->getDoctrine()->getManager();
        $custRepo = $em->getRepository("MatrixServiceBundle:Customers");
        $user = $em->getrepository("MatrixServiceBundle:Users")->findOneBy(array("id" => $user));
        $paymentVersion = $em->getRepository("MatrixServiceBundle:ChequePayment")->findMaxVersion();

        foreach($payments as $payment){

            $customer = $custRepo->findOneBy(array("id" => $payment->customer_id));
            $currency = $em->getRepository("MatrixServiceBundle:Currency")->findOneBy(array("id" => $payment->currency_id));

            $newPayment = new ChequePayment();
            $newPayment
                ->setVersion($paymentVersion)
                ->setStatus(Statuses::ACTIVE)
                ->setSlipNumber($payment->slip_number)
                ->setDate(DateTime::createFromFormat('d.m.Y', $payment->date))
                ->setSpecialCode($payment->special_code)
                ->setCurrency($currency)
                ->setAmount($payment->amount)
                ->setDescription($payment->description)
                ->setCustomer($customer)
                ->setMobileUser($user)
                ->setIssuerName($payment->issuer_name)
                ->setSerialNumber($payment->serial_number)
                ->setDueDate(DateTime::createFromFormat('d.m.Y', $payment->due_date));

            $em->persist($newPayment);
        }

        $em->flush();

        return $this->renderData(null);
    }

} 
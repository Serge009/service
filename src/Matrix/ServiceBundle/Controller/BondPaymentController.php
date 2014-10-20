<?php
/**
 * Created by PhpStorm.
 * User: Matrix
 * Date: 20.10.14
 * Time: 9:40
 */

namespace Matrix\ServiceBundle\Controller;


use DateTime;
use Exception;
use Matrix\ServiceBundle\Entity\BondPayment;
use Matrix\ServiceBundle\Entity\Statuses;
use Matrix\ServiceBundle\Utils\Errors;
use Symfony\Component\HttpFoundation\Request;

class BondPaymentController extends AppController {

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
        $paymentVersion = $em->getRepository("MatrixServiceBundle:BondPayment")->findMaxVersion();

        foreach($payments as $payment){

            $customer = $custRepo->findOneBy(array("id" => $payment->customer));
            $currency = $em->getRepository("MatrixServiceBundle:Currency")->findOneBy(array("id" => $payment->currency));

            $newPayment = new BondPayment();
            $newPayment->setSlipNumber($payment->slip_number)
                ->setDate(DateTime::createFromFormat('d.m.Y', $payment->date))
                ->setSpecialCode($payment->special_code)
                ->setCurrency($currency)
                ->setAmount($payment->amount)
                ->setDescription($payment->description)
                ->setIssuerName($payment->issuer_name)
                ->setGuarantorName($payment->guarantor_name)
                ->setSerialNumber($payment->serial_number)
                ->setDueDate(DateTime::createFromFormat('d.m.Y', $payment->due_date))
                ->setCustomer($customer)
                ->setMobileUser($user)
                ->setVersion($paymentVersion)
                ->setStatus(Statuses::ACTIVE);

            $em->persist($newPayment);
        }

        $em->flush();

        return $this->renderData(null);
    }

} 
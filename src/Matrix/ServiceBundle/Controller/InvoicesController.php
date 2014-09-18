<?php
/**
 * Created by PhpStorm.
 * User: Matrix
 * Date: 18.08.14
 * Time: 15:53
 */

namespace Matrix\ServiceBundle\Controller;


use DateTime;
use Exception;
use Matrix\ServiceBundle\Entity\Dispatches;
use Matrix\ServiceBundle\Entity\DispatchItem;
use Matrix\ServiceBundle\Entity\InvoiceItem;
use Matrix\ServiceBundle\Entity\Invoices;
use Matrix\ServiceBundle\Entity\OrderItem;
use Matrix\ServiceBundle\Entity\Orders;
use Matrix\ServiceBundle\Entity\Statuses;
use Matrix\ServiceBundle\Utils\Errors;
use Symfony\Component\HttpFoundation\Request;

class InvoicesController extends AppController {

    public function indexAction(Request $request){
        try{
            $data = json_decode($request->request->get('data'));

            if(!$data || !$session = $this->isSessionValid($data->session)){
                return $this->renderError(Errors::INCORRECT_REQUEST);
            }

            return $this->createInvoice($data->invoices, $session->getDevice()->getUser()->getId());
//            return $this->renderData(array());

        } catch(Exception $e){
            //echo $e->getMessage();
            $this->get('logger')->error($e->getMessage() . ' ' . __FILE__ . ' on line = ' . __LINE__);
            return $this->renderError(Errors::INCORRECT_REQUEST);
        }
    }

    private function createInvoice(array $invoices, $user){


        $em = $this->getDoctrine()->getManager();
        $custRepo = $em->getRepository("MatrixServiceBundle:Customers");
        $user = $em->getrepository("MatrixServiceBundle:Users")->findOneBy(array("id" => $user));
        $invoiceVersion = $em->getRepository("MatrixServiceBundle:Invoices")->findMaxVersion();
        $itemsVersion = $em->getRepository("MatrixServiceBundle:InvoiceItem")->findMaxVersion();

        $res = array(
            "invoices" => array()
            //"items" => array()
        );



        foreach($invoices as $invoice){

            $customer = $custRepo->findOneBy(array("id" => $invoice->customer));
            $department = $em->getRepository("MatrixServiceBundle:Department")->findOneBy(array("id" => $invoice->department));
            $division = $em->getRepository("MatrixServiceBundle:Division")->findOneBy(array("id" => $invoice->division));
            $warehouse = $em->getRepository("MatrixServiceBundle:Warehouse")->findOneBy(array("id" => $invoice->warehouse));
            $plant = $em->getRepository("MatrixServiceBundle:Plant")->findOneBy(array("id" => $invoice->plant));
            $currency = $em->getRepository("MatrixServiceBundle:Currency")->findOneBy(array("id" => $invoice->currency));

            $newInvoice = new Invoices();
            $newInvoice->setSlipNumber($invoice->slip_number)
                ->setSpecialCode($invoice->special_code)
                ->setAdvancedPayment($invoice->advance_payment)
                ->setDate(DateTime::createFromFormat('d.m.Y', $invoice->date))
                ->setSubtotal($invoice->subtotal)
                ->setTotal($invoice->total)
                ->setVersion($invoiceVersion)
                ->setStatus(Statuses::ACTIVE)
                ->setUser($user)
                ->setCustomer($customer)
                ->setDepartment($department)
                ->setDivision($division)
                ->setWarehouse($warehouse)
                ->setPlant($plant)
                ->setCurrency($currency);

            $em->persist($newInvoice);
            array_push($res['invoices'], $newInvoice);

            $items = array();
            foreach($invoice->invoice_items as $item){
                $unitDetail = $em->getRepository("MatrixServiceBundle:UnitDetail")->findOneBy(array("id" => $item->unit_detail));
                $invoiceItem = new InvoiceItem();

                $invoiceItem->setItem($item->item)
                    ->setInvoice($newInvoice)
                    ->setStatus(Statuses::ACTIVE)
                    ->setType($item->type)
                    ->setVersion($itemsVersion)
                    ->setUnitDetail($unitDetail)
                    ->setPrice($item->price)
                    ->setQuantity($item->quantity);

                $em->persist($invoiceItem);
                //array_push($res['items'], $invoiceItem);
                array_push($items, $invoiceItem);


            }

            $newInvoice->setInvoiceItems($items);

        }

        $em->flush();


        $res['invoices'] = $this->toArray($res['invoices']);
        //var_dump($res['orders']);
        //$res['items'] = $this->toArray($res['items']);

        return $this->renderData(null);
        //return $this->renderData($res);



    }

} 
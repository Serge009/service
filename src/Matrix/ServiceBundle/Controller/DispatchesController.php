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
use Matrix\ServiceBundle\Entity\OrderItem;
use Matrix\ServiceBundle\Entity\Orders;
use Matrix\ServiceBundle\Entity\Statuses;
use Matrix\ServiceBundle\Utils\Errors;
use Symfony\Component\HttpFoundation\Request;

class DispatchesController extends AppController {

    public function indexAction(Request $request){
        try{
            $data = json_decode($request->request->get('data'));

            if(!$data || !$session = $this->isSessionValid($data->session)){
                return $this->renderError(Errors::INCORRECT_REQUEST);
            }

            return $this->createDispatch($data->dispatches, $session->getDevice()->getUser()->getId());
//            return $this->renderData(array());

        } catch(Exception $e){
            //echo $e->getMessage();
            $this->get('logger')->error($e->getMessage() . ' ' . __FILE__ . ' on line = ' . __LINE__);
            return $this->renderError(Errors::INCORRECT_REQUEST);
        }
    }

    private function createDispatch(array $dispatches, $user){


        $em = $this->getDoctrine()->getManager();
        $custRepo = $em->getRepository("MatrixServiceBundle:Customers");
        $user = $em->getrepository("MatrixServiceBundle:Users")->findOneBy(array("id" => $user));
        $dispatchVersion = $em->getRepository("MatrixServiceBundle:Dispatches")->findMaxVersion();
        $itemsVersion = $em->getRepository("MatrixServiceBundle:DispatchItem")->findMaxVersion();

        $res = array(
            "dispatches" => array()
            //"items" => array()
        );



        foreach($dispatches as $dispatch){

            $customer = $custRepo->findOneBy(array("id" => $dispatch->customer));
            $department = $em->getRepository("MatrixServiceBundle:Department")->findOneBy(array("id" => $dispatch->department));
            $division = $em->getRepository("MatrixServiceBundle:Division")->findOneBy(array("id" => $dispatch->division));
            $warehouse = $em->getRepository("MatrixServiceBundle:Warehouse")->findOneBy(array("id" => $dispatch->warehouse));
            $plant = $em->getRepository("MatrixServiceBundle:Plant")->findOneBy(array("id" => $dispatch->plant));
            $currency = $em->getRepository("MatrixServiceBundle:Currency")->findOneBy(array("id" => $dispatch->currency));

            $newDispatch = new Dispatches();
            $newDispatch->setSlipNumber($dispatch->slip_number)
                ->setSpecialCode($dispatch->special_code)
                ->setAdvancedPayment($dispatch->advance_payment)
                ->setDate(DateTime::createFromFormat('d.m.Y', $dispatch->date))
                ->setSubtotal($dispatch->subtotal)
                ->setTotal($dispatch->total)
                ->setVersion($dispatchVersion)
                ->setStatus(Statuses::ACTIVE)
                ->setUser($user)
                ->setCustomer($customer)
                ->setDepartment($department)
                ->setDivision($division)
                ->setWarehouse($warehouse)
                ->setPlant($plant)
                ->setCurrency($currency);

            $em->persist($newDispatch);
            array_push($res['dispatches'], $newDispatch);

            $items = array();
            foreach($dispatch->dispatch_items as $item){
                $unitDetail = $em->getRepository("MatrixServiceBundle:UnitDetail")->findOneBy(array("id" => $item->unit_detail));
                $orderItem = new DispatchItem();

                $orderItem->setItem($item->item)
                    ->setDispatch($newDispatch)
                    ->setStatus(Statuses::ACTIVE)
                    ->setType($item->type)
                    ->setVersion($itemsVersion)
                    ->setUnitDetail($unitDetail)
                    ->setPrice($item->price)
                    ->setQuantity($item->quantity);

                $em->persist($orderItem);
                //array_push($res['items'], $orderItem);
                array_push($items, $orderItem);


            }

            $newDispatch->setDispatchItems($items);

        }

        $em->flush();


        $res['dispatches'] = $this->toArray($res['dispatches']);
        //var_dump($res['orders']);
        //$res['items'] = $this->toArray($res['items']);

        return $this->renderData(null);
        //return $this->renderData($res);



    }

} 
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
use Matrix\ServiceBundle\Entity\OrderItem;
use Matrix\ServiceBundle\Entity\Orders;
use Matrix\ServiceBundle\Entity\Statuses;
use Matrix\ServiceBundle\Utils\Errors;
use Symfony\Component\HttpFoundation\Request;

class OrdersController extends AppController {

    public function indexAction(Request $request){
        try{
            $data = json_decode($request->request->get('data'));

            if(!$data || !$session = $this->isSessionValid($data->session)){
                return $this->renderError(Errors::INCORRECT_REQUEST);
            }

            return $this->createOrder($data->orders, $session->getDevice()->getUser()->getId());
//            return $this->renderData(array());

        } catch(Exception $e){
            //echo $e->getMessage();
            $this->get('logger')->error($e->getMessage() . ' ' . __FILE__ . ' on line = ' . __LINE__);
            return $this->renderError(Errors::INCORRECT_REQUEST);
        }
    }

    private function createOrder(array $orders, $user){


        $em = $this->getDoctrine()->getManager();
        $custRepo = $em->getRepository("MatrixServiceBundle:Customers");
        $user = $em->getrepository("MatrixServiceBundle:Users")->findOneBy(array("id" => $user));
        $ordersVersion = $em->getRepository("MatrixServiceBundle:Orders")->findMaxVersion();
        $itemsVersion = $em->getRepository("MatrixServiceBundle:OrderItem")->findMaxVersion();

        $res = array(
            "orders" => array()
            //"items" => array()
        );



        foreach($orders as $order){

            $customer = $custRepo->findOneBy(array("id" => $order->customer));
            $department = $em->getRepository("MatrixServiceBundle:Department")->findOneBy(array("id" => $order->department));
            $division = $em->getRepository("MatrixServiceBundle:Division")->findOneBy(array("id" => $order->division));
            $warehouse = $em->getRepository("MatrixServiceBundle:Warehouse")->findOneBy(array("id" => $order->warehouse));
            $plant = $em->getRepository("MatrixServiceBundle:Plant")->findOneBy(array("id" => $order->plant));

            $newOrder = new Orders();
            $newOrder->setDate(new DateTime())
                ->setSlipNumber($order->slipNumber)
                ->setSpecialCode($order->specialCode)
                ->setDate(DateTime::createFromFormat('d.m.Y', $order->date))
                ->setSubtotal($order->subtotal)
                ->setTotal($order->total)
                ->setVersion($ordersVersion)
                ->setStatus(Statuses::ACTIVE)
                ->setUser($user)
                ->setCustomer($customer)
                ->setDepartment($department)
                ->setDivision($division)
                ->setWarehouse($warehouse)
                ->setPlant($plant);

            $em->persist($newOrder);
            array_push($res['orders'], $newOrder);

            $items = array();
            foreach($order->orderItems as $item){
                $unitDetail = $em->getRepository("MatrixServiceBundle:UnitDetail")->findOneBy(array("id" => $item->unit_detail));
                $orderItem = new OrderItem();

                $orderItem->setItem($item->item)
                    ->setOrder($newOrder)
                    ->setStatus(Statuses::ACTIVE)
                    ->setType($item->type)
                    ->setVersion($itemsVersion)
                    ->setUnitDetail($unitDetail);

                $em->persist($orderItem);
                //array_push($res['items'], $orderItem);
                array_push($items, $orderItem);


            }

            $newOrder->setOrderItems($items);

        }

        $em->flush();


        $res['orders'] = $this->toArray($res['orders']);
        //var_dump($res['orders']);
        //$res['items'] = $this->toArray($res['items']);

        return $this->renderData(array());
        //return $this->renderData($res);



    }

} 
<?php
/**
 * Created by PhpStorm.
 * User: SERGE
 * Date: 17.08.14
 * Time: 16:35
 */

namespace Matrix\ServiceBundle\Controller;


use Exception;
use Matrix\ServiceBundle\Entity\Company;
use Matrix\ServiceBundle\Entity\Users;
use Matrix\ServiceBundle\Utils\Errors;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class SynchController extends AppController
{

    public function indexAction(Request $request)
    {
        try {

            $data = json_decode($request->request->get('data'));

            if (!$data || !$session = $this->isSessionValid($data->session)) {

                return $this->renderError(Errors::INCORRECT_REQUEST);
            }

            $res = array();


            if(isset($data->versions->products)){
                $products = $this->synchProducts($data->versions->products,
                    $session->getDevice()->getUser()->getCompany());

                $res['products'] = $products;
            }

            if(isset($data->versions->services)){
                $services = $this->synchServices($data->versions->services,
                    $session->getDevice()->getUser()->getCompany());

                $res['services'] = $services;
            }

            if(isset($data->versions->customers)){
                $customers = $this->synchCustomers($data->versions->customers,
                    $session->getDevice()->getUser()->getCompany());

                $res['customers'] = $customers;
            }

            if(isset($data->versions->unit)){
                $units = $this->synchUnit($data->versions->unit,
                    $session->getDevice()->getUser()->getCompany());

                $res['unit'] = $units;
            }

            if(isset($data->versions->currency)){
                $units = $this->synchCurrency($data->versions->currency,
                    $session->getDevice()->getUser()->getCompany());

                $res['currency'] = $units;
            }

            if(isset($data->versions->department)){
                $units = $this->synchDepartment($data->versions->department,
                    $session->getDevice()->getUser()->getCompany());

                $res['department'] = $units;
            }

            if(isset($data->versions->division)){
                $units = $this->synchDivision($data->versions->division,
                    $session->getDevice()->getUser()->getCompany());

                $res['division'] = $units;
            }

            if(isset($data->versions->plant)){
                $units = $this->synchPlant($data->versions->plant,
                    $session->getDevice()->getUser()->getCompany());

                $res['plant'] = $units;
            }

            if(isset($data->versions->warehouse)){
                $units = $this->synchWarehouse($data->versions->warehouse,
                    $session->getDevice()->getUser()->getCompany());

                $res['warehouse'] = $units;
            }

            if(isset($data->versions->unit_detail)){
                $units = $this->synchUnitDetail($data->versions->unit_detail,
                    $session->getDevice()->getUser()->getCompany());

                $res['unit_detail'] = $units;
            }

            if(isset($data->versions->product_prices)){
                $units = $this->synchProductPrices($data->versions->product_prices,
                    $session->getDevice()->getUser()->getCompany());

                $res['product_prices'] = $units;
            }

            if(isset($data->versions->service_prices)){
                $units = $this->synchServicePrices($data->versions->service_prices,
                    $session->getDevice()->getUser()->getCompany());

                $res['service_prices'] = $units;
            }

            if(isset($data->versions->order_item)){
                $units = $this->synchOrderItem($data->versions->order_item,
                    $session->getDevice()->getUser());

                $res['order_item'] = $units;
            }

            if(isset($data->versions->orders)){
                $units = $this->synchOrders($data->versions->orders,
                    $session->getDevice()->getUser());

                $res['orders'] = $units;
            }

            return $this->renderData($res);

        } catch (Exception $e) {
            $this->get('logger')->error($e->getMessage() . ' ' . __FILE__ . ' on line = ' . __LINE__);

            return $this->renderError(Errors::INCORRECT_REQUEST);
        }
    }

    private function synchProducts($version, Company $company)
    {
        $products = $this->getDoctrine()
            ->getRepository("MatrixServiceBundle:Products")
            ->findByVersion($version, $company);

        $res = array();
        foreach ($products as $product) {
            array_push($res, $product->toArray());
        }

        return $res;
    }

    private function synchServices($version, Company $company)
    {
        $services = $this->getDoctrine()
            ->getRepository("MatrixServiceBundle:Services")
            ->findByVersion($version, $company);

        $res = array();
        foreach ($services as $service) {
            array_push($res, $service->toArray());
        }

        return $res;
    }

    private function synchCustomers($version, Company $company)
    {
        $customers = $this->getDoctrine()
            ->getRepository("MatrixServiceBundle:Customers")
            ->findByVersion($version, $company);

        $res = array();
        foreach($customers as $customer){
            array_push($res, $customer->toArray());
        }

        return $res;
    }

    private function synchUnit($version, Company $company)
    {
        $units = $this->getDoctrine()
            ->getRepository("MatrixServiceBundle:Unit")
            ->findByVersion($version, $company);

        $res = array();
        foreach($units as $unit){
            array_push($res, $unit->toArray());
        }

        return $res;
    }

    private function synchCurrency($version, Company $company)
    {
        $currencies = $this->getDoctrine()
            ->getRepository("MatrixServiceBundle:Currency")
            ->findByVersion($version, $company);

        $res = array();
        foreach($currencies as $currency){
            array_push($res, $currency->toArray());
        }

        return $res;
    }

    private function synchDepartment($version, Company $company)
    {
        $departments = $this->getDoctrine()
            ->getRepository("MatrixServiceBundle:Department")
            ->findByVersion($version, $company);

        $res = array();
        foreach($departments as $department){
            array_push($res, $department->toArray());
        }

        return $res;
    }

    private function synchDivision($version, Company $company)
    {
        $divisions = $this->getDoctrine()
            ->getRepository("MatrixServiceBundle:Division")
            ->findByVersion($version, $company);

        $res = array();
        foreach($divisions as $division){
            array_push($res, $division->toArray());
        }

        return $res;
    }

    private function synchPlant($version, Company $company)
    {
        $plants = $this->getDoctrine()
            ->getRepository("MatrixServiceBundle:Plant")
            ->findByVersion($version, $company);

        $res = array();
        foreach($plants as $plant){
            array_push($res, $plant->toArray());
        }

        return $res;
    }


    private function synchWarehouse($version, Company $company)
{
    $warehouses = $this->getDoctrine()
        ->getRepository("MatrixServiceBundle:Warehouse")
        ->findByVersion($version, $company);

    $res = array();
    foreach($warehouses as $warehouse){
        array_push($res, $warehouse->toArray());
    }

    return $res;
}

    private function synchUnitDetail($version, Company $company)
    {
        $unitDetails = $this->getDoctrine()
            ->getRepository("MatrixServiceBundle:UnitDetail")
            ->findByVersion($version, $company);

        $res = array();
        foreach($unitDetails as $detail){
            array_push($res, $detail->toArray());
        }

        return $res;
    }

    private function synchServicePrices($version, Company $company)
    {
        $prices = $this->getDoctrine()
            ->getRepository("MatrixServiceBundle:ServicePrices")
            ->findByVersion($version, $company);

        $res = array();
        foreach($prices as $price){
            array_push($res, $price->toArray());
        }

        return $res;
    }

    private function synchProductPrices($version, Company $company)
    {
        $prices = $this->getDoctrine()
            ->getRepository("MatrixServiceBundle:ProductPrices")
            ->findByVersion($version, $company);

        $res = array();
        foreach($prices as $price){
            array_push($res, $price->toArray());
        }

        return $res;
    }

    private function synchOrderItem($version, Users $user)
    {
        $items = $this->getDoctrine()
            ->getRepository("MatrixServiceBundle:OrderItem")
            ->findByVersion($version, $user);

        $res = array();
        foreach($items as $item){
            array_push($res, $item->toArray());
        }

        return $res;
    }

    private function synchOrders($version, Users $user)
    {
        $orders = $this->getDoctrine()
            ->getRepository("MatrixServiceBundle:Orders")
            ->findByVersion($version, $user);

        $res = array();
        foreach($orders as $order){
            array_push($res, $order->toArray());
        }

        return $res;
    }

} 
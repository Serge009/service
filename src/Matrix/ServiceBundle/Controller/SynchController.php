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

} 
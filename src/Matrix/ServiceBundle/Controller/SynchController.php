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


            $products = $this->synchProducts($data->versions->products,
                $session->getDevice()->getUser()->getCompany());

            $services = $this->synchServices($data->versions->services,
                $session->getDevice()->getUser()->getCompany());

            $customers = $this->synchCustomers($data->versions->customers,
                $session->getDevice()->getUser()->getCompany());


            $res = array(
                "products" => $products,
                "services" => $services,
                "customers" => $customers
            );

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


} 
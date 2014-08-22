<?php
/**
 * Created by PhpStorm.
 * User: SERGE
 * Date: 17.08.14
 * Time: 11:52
 */

namespace Matrix\ServiceBundle\Controller;


use \Exception;
use Matrix\ServiceBundle\Entity\Sessions;
use Matrix\ServiceBundle\Entity\Statuses;
use Matrix\ServiceBundle\Utils\Errors;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class CustomersController extends AppController {

    public function indexAction(Request $request){
        try{
            $data = json_decode($request->request->get('data'));

            if(!$data || !$session = $this->isSessionValid($data->session)){
                return $this->renderError(Errors::INCORRECT_REQUEST);
            }

            return $this->getCustomersList($session);

        } catch(Exception $e){
            $this->get('logger')->error($e->getMessage() . ' ' . __FILE__ . ' on line = ' . __LINE__);
            return $this->renderError(Errors::INCORRECT_REQUEST);
        }
    }


    private function getCustomersList(Sessions $session){

        $customers = $this->getDoctrine()->getRepository("MatrixServiceBundle:Customers")
            ->findBy(array("company" => $session->getDevice()->getUser()->getCompany(),
                            "status" => Statuses::ACTIVE));

        $res = array();

        foreach($customers as $customer){
            array_push($res, $customer->toArray());
        }

        return $this->renderData($res);
    }

    public function synchAction(Request $request){
        try{
            $data = json_decode($request->request->get('data'));

            if(!$data || !$session = $this->isSessionValid($data->session)){
                return $this->renderError(Errors::INCORRECT_REQUEST);
            }

            return $this->synchCustomers($data->versions->customers,
                $session->getDevice()->getUser()->getCompany()->getId());

        } catch(Exception $e){
            $this->get('logger')->error($e->getMessage() . ' ' . __FILE__ . ' on line = ' . __LINE__);
            return $this->renderError(Errors::INCORRECT_REQUEST);
        }
    }

    private function synchCustomers($version, $company)
    {

        $company = $this->getDoctrine()
            ->getRepository("MatrixServiceBundle:Company")
            ->findOneBy(array("id" => $company));

        $customers = $this->getDoctrine()
            ->getRepository("MatrixServiceBundle:Customers")
            ->findByVersion($version, $company);

        $res = array();
        foreach($customers as $customer){
            array_push($res, $customer->toArray());
        }

        return $this->renderData($res);
    }

} 
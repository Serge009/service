<?php
/**
 * Created by PhpStorm.
 * User: Matrix
 * Date: 01.09.14
 * Time: 17:06
 */

namespace Matrix\AdminBundle\Controller;


use Exception;
use Matrix\AdminBundle\Entity\Customers;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class CustomerController extends Controller {

    public function getCustomersAction(){
        try{
            $customers = $this->getDoctrine()
                ->getRepository("MatrixAdminBundle:Customers")
                ->findBy(array("company" => $this->getUser()->getCompany()));

            return $this->render("MatrixAdminBundle:Customer:customers.html.twig", array("customers" => $customers));
        } catch(Exception $e){
            $this->get('logger')->error($e->getMessage() . ' ' . __FILE__ . ' on line = ' . __LINE__);
            return new Response();
        }
    }

    public function createCustomerFormAction(){
        return $this->render("MatrixAdminBundle:Customer:customerForm.html.twig");
    }

    public function createCustomerAction(Request $request){
        try{
            $name = $request->request->get('customer-name');
            $longitude = $request->request->get('customer-longitude');
            $latitude = $request->request->get('customer-latitude');

            $company = $this->getUser()->getCompany();
            $version = $this->getDoctrine()->getRepository("MatrixAdminBundle:Customers")->findMaxVersion();

            $customer = new Customers();
            $customer->setName($name)
                ->setCompany($company)
                ->setVersion($version)
                ->setStatus(Statuses::ACTIVE)
                ->setLatitude($latitude)
                ->setLongitude($longitude);


            $em = $this->getDoctrine()->getManager();
            $em->persist($customer);
            $em->flush();

            $this->get('session')->getFlashBag()->add(
                'notice',
                'Your changes were saved!'
            );

        } catch(Exception $e){
            $this->get('logger')->error($e->getMessage() . ' ' . __FILE__ . ' on line = ' . __LINE__);

            $this->get('session')->getFlashBag()->add(
                'notice',
                'Something went wrong!'
            );

        }

        return $this->forward("MatrixAdminBundle:Customer:createCustomerForm");
    }

} 
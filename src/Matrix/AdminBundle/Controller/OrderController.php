<?php
/**
 * Created by PhpStorm.
 * User: Matrix
 * Date: 02.09.14
 * Time: 16:09
 */

namespace Matrix\AdminBundle\Controller;


use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class OrderController extends Controller {

    public function getOrdersAction(){
        try{
            $orders = $this->getDoctrine()
                ->getRepository("MatrixAdminBundle:Orders")
                ->findAllByCompany($this->getUser()->getCompany());

            return $this->render("MatrixAdminBundle:Order:orders.html.twig", array("orders" => $orders));
        } catch(Exception $e){
            $this->get('logger')->error($e->getMessage() . ' ' . __FILE__ . ' on line = ' . __LINE__);
            return new Response();
        }
    }

   /* public function createDepartmentFormAction(){
        return $this->render("MatrixAdminBundle:Department:departmentForm.html.twig");
    }

    public function createDepartmentAction(Request $request){
        try{
            $name = $request->request->get('department-name');
            $company = $this->getUser()->getCompany();
            $version = $this->getDoctrine()->getRepository("MatrixAdminBundle:Department")->findMaxVersion();

            $department = new Department();
            $department->setName($name)
                ->setCompany($company)
                ->setVersion($version);


            $em = $this->getDoctrine()->getManager();
            $em->persist($department);
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

        return $this->forward("MatrixAdminBundle:Department:createDepartmentForm");
    }*/

} 
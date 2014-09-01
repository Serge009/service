<?php
/**
 * Created by PhpStorm.
 * User: Matrix
 * Date: 01.09.14
 * Time: 17:36
 */

namespace Matrix\AdminBundle\Controller;


use Exception;
use Matrix\AdminBundle\Entity\Department;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class DepartmentController extends Controller {

    public function getDepartmentsAction(){
        try{
            $departments = $this->getDoctrine()
                ->getRepository("MatrixAdminBundle:Department")
                ->findBy(array("company" => $this->getUser()->getCompany()));

            return $this->render("MatrixAdminBundle:Department:departments.html.twig", array("departments" => $departments));
        } catch(Exception $e){
            $this->get('logger')->error($e->getMessage() . ' ' . __FILE__ . ' on line = ' . __LINE__);
            return new Response();
        }
    }

    public function createDepartmentFormAction(){
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
    }

} 
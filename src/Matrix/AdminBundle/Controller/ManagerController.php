<?php
/**
 * Created by PhpStorm.
 * User: Matrix
 * Date: 29.08.14
 * Time: 9:38
 */

namespace Matrix\AdminBundle\Controller;


use Exception;
use Matrix\AdminBundle\Entity\Department;
use Matrix\AdminBundle\Entity\Plant;
use Matrix\AdminBundle\Entity\Users;
use Matrix\AdminBundle\Entity\UserStatus;
use Matrix\AdminBundle\Entity\UserType;
use Matrix\AdminBundle\Entity\Warehouse;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class ManagerController extends Controller {

    public function getMobileUsersAction(){
        try{
            $mobileUsers = $this->getDoctrine()
                ->getRepository("MatrixAdminBundle:Users")
                ->findBy(array("type" => UserType::MOBILE_USER,
                    "company" => $this->getUser()->getCompany()));

            return $this->render("MatrixAdminBundle:Manager:mobileUsers.html.twig", array("users" => $mobileUsers));
        } catch(Exception $e){
            $this->get('logger')->error($e->getMessage() . ' ' . __FILE__ . ' on line = ' . __LINE__);
            return new Response();
        }
    }

    public function createMobileUserFormAction(){
        return $this->render("MatrixAdminBundle:Manager:mobileUserForm.html.twig");
    }

    public function createMobileUserAction(Request $request){
        try{
            $name = $request->request->get('m-user-name');
            $surname = $request->request->get('m-user-surname');
            $email = $request->request->get('m-user-email');
            $password = $request->request->get('m-user-password');


            $factory = $this->get('security.encoder_factory');

            $company = $this->getUser()->getCompany();



            $user = new Users();

            $user->setSalt(Users::generateSalt());
            $encoder = $factory->getEncoder($user);
            $password = $encoder->encodePassword($password, $user->getSalt());

            $user->setPassword($password)
                ->setType(UserType::MOBILE_USER)
                ->setStatus(UserStatus::ACTIVE)
                ->setCompany($company)
                ->setEmail($email)
                ->setName($name)
                ->setSurname($surname)
                ->setCreator($this->getUser());

            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
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

        return $this->forward("MatrixAdminBundle:Manager:createMobileUserForm");
    }

    public function getDepartmentsAction(){
        try{
            $departments = $this->getDoctrine()
                ->getRepository("MatrixAdminBundle:Department")
                ->findBy(array("company" => $this->getUser()->getCompany()));

            return $this->render("MatrixAdminBundle:Manager:departments.html.twig", array("departments" => $departments));
        } catch(Exception $e){
            $this->get('logger')->error($e->getMessage() . ' ' . __FILE__ . ' on line = ' . __LINE__);
            return new Response();
        }
    }

    public function createDepartmentFormAction(){
        return $this->render("MatrixAdminBundle:Manager:departmentForm.html.twig");
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

        return $this->forward("MatrixAdminBundle:Manager:createDepartmentForm");
    }

    public function getPlantsAction(){
        try{
            $plants = $this->getDoctrine()
                ->getRepository("MatrixAdminBundle:Plant")
                ->findBy(array("company" => $this->getUser()->getCompany()));

            return $this->render("MatrixAdminBundle:Manager:plants.html.twig", array("plants" => $plants));
        } catch(Exception $e){
            $this->get('logger')->error($e->getMessage() . ' ' . __FILE__ . ' on line = ' . __LINE__);
            return new Response();
        }
    }

    public function createPlantFormAction(){
        return $this->render("MatrixAdminBundle:Manager:plantForm.html.twig");
    }

    public function createPlantAction(Request $request){
        try{
            $name = $request->request->get('plant-name');
            $company = $this->getUser()->getCompany();
            $version = $this->getDoctrine()->getRepository("MatrixAdminBundle:Plant")->findMaxVersion();

            $plant = new Plant();
            $plant->setName($name)
                ->setCompany($company)
                ->setVersion($version);


            $em = $this->getDoctrine()->getManager();
            $em->persist($plant);
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

        return $this->forward("MatrixAdminBundle:Manager:createPlantForm");
    }

    public function getWarehousesAction(){
        try{
            $warehouses = $this->getDoctrine()
                ->getRepository("MatrixAdminBundle:Warehouse")
                ->findBy(array("company" => $this->getUser()->getCompany()));

            return $this->render("MatrixAdminBundle:Manager:warehouses.html.twig", array("warehouses" => $warehouses));
        } catch(Exception $e){
            $this->get('logger')->error($e->getMessage() . ' ' . __FILE__ . ' on line = ' . __LINE__);
            return new Response();
        }
    }

    public function createWarehouseFormAction(){
        return $this->render("MatrixAdminBundle:Manager:warehouseForm.html.twig");
    }

    public function createWarehouseAction(Request $request){
        try{
            $name = $request->request->get('warehouse-name');
            $company = $this->getUser()->getCompany();
            $version = $this->getDoctrine()->getRepository("MatrixAdminBundle:Warehouse")->findMaxVersion();

            $warehouse = new Warehouse();
            $warehouse->setName($name)
                ->setCompany($company)
                ->setVersion($version);


            $em = $this->getDoctrine()->getManager();
            $em->persist($warehouse);
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

        return $this->forward("MatrixAdminBundle:Manager:createWarehouseForm");
    }


} 
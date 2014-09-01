<?php
/**
 * Created by PhpStorm.
 * User: Matrix
 * Date: 01.09.14
 * Time: 17:26
 */

namespace Matrix\AdminBundle\Controller;


use Exception;
use Matrix\AdminBundle\Entity\Warehouse;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class WarehouseController extends Controller {

    public function getWarehousesAction(){
        try{
            $warehouses = $this->getDoctrine()
                ->getRepository("MatrixAdminBundle:Warehouse")
                ->findBy(array("company" => $this->getUser()->getCompany()));

            return $this->render("MatrixAdminBundle:Warehouse:warehouses.html.twig", array("warehouses" => $warehouses));
        } catch(Exception $e){
            $this->get('logger')->error($e->getMessage() . ' ' . __FILE__ . ' on line = ' . __LINE__);
            return new Response();
        }
    }

    public function createWarehouseFormAction(){
        return $this->render("MatrixAdminBundle:Warehouse:warehouseForm.html.twig");
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

        return $this->forward("MatrixAdminBundle:Warehouse:createWarehouseForm");
    }

} 
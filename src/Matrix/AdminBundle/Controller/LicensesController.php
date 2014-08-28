<?php
/**
 * Created by PhpStorm.
 * User: Matrix
 * Date: 28.08.14
 * Time: 12:05
 */

namespace Matrix\AdminBundle\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class LicensesController extends Controller {

    public function indexAction(){

        try{

            $licenses = $this->getDoctrine()
                ->getRepository("MatrixAdminBundle:Licenses")
                ->findAll();

            return $this->render("MatrixAdminBundle:Distributor:licenses.html.twig", array("licenses" => $licenses));

        } catch(Exception $e){
            $this->get('logger')->error($e->getMessage() . ' ' . __FILE__ . ' on line = ' . __LINE__);

            $this->get('session')->getFlashBag()->add(
                'error',
                'Something went wrong!'
            );

            return $this->render("MatrixAdminBundle:Distributor:licenses.html.twig", array("licenses" => array()));
        }

    }


    public function getByDistributorAction(){

        try{

            var_dump($this->getUser()->getRoles());
            $licenses = $this->getDoctrine()
                ->getRepository("MatrixAdminBundle:Licenses")
                ->findBy(array("distributor" => $this->getUser()));

            return $this->render("MatrixAdminBundle:Distributor:licenses.html.twig", array("licenses" => $licenses));

        } catch(Exception $e){
            $this->get('logger')->error($e->getMessage() . ' ' . __FILE__ . ' on line = ' . __LINE__);

            $this->get('session')->getFlashBag()->add(
                'error',
                'Something went wrong!'
            );

            return $this->render("MatrixAdminBundle:Distributor:licenses.html.twig", array("licenses" => array()));
        }

    }


} 
<?php
/**
 * Created by PhpStorm.
 * User: Matrix
 * Date: 01.09.14
 * Time: 17:00
 */

namespace Matrix\AdminBundle\Controller;


use Exception;
use Matrix\AdminBundle\Entity\Statuses;
use Matrix\AdminBundle\Entity\Unit;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class UnitController extends Controller {

    public function getUnitsAction(){
        try{
            $units = $this->getDoctrine()
                ->getRepository("MatrixAdminBundle:Unit")
                ->findBy(array("company" => $this->getUser()->getCompany()));

            return $this->render("MatrixAdminBundle:Unit:units.html.twig", array("units" => $units));
        } catch(Exception $e){
            $this->get('logger')->error($e->getMessage() . ' ' . __FILE__ . ' on line = ' . __LINE__);
            return new Response();
        }
    }

    public function createUnitFormAction(){
        return $this->render("MatrixAdminBundle:Unit:unitForm.html.twig");
    }

    public function createUnitAction(Request $request){
        try{
            $name = $request->request->get('unit-name');

            $company = $this->getUser()->getCompany();
            $version = $this->getDoctrine()->getRepository("MatrixAdminBundle:Unit")->findMaxVersion();

            $unit = new Unit();
            $unit->setName($name)
                ->setCompany($company)
                ->setVersion($version)
                ->setStatus(Statuses::ACTIVE);


            $em = $this->getDoctrine()->getManager();
            $em->persist($unit);
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

        return $this->forward("MatrixAdminBundle:Unit:createUnitForm");
    }

} 
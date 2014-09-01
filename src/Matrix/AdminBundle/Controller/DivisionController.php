<?php
/**
 * Created by PhpStorm.
 * User: Matrix
 * Date: 01.09.14
 * Time: 17:14
 */

namespace Matrix\AdminBundle\Controller;


use Exception;
use Matrix\AdminBundle\Entity\Division;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class DivisionController extends Controller {

    public function getDivisionsAction(){
        try{
            $divisions = $this->getDoctrine()
                ->getRepository("MatrixAdminBundle:Division")
                ->findBy(array("company" => $this->getUser()->getCompany()));

            return $this->render("MatrixAdminBundle:Division:divisions.html.twig", array("divisions" => $divisions));
        } catch(Exception $e){
            $this->get('logger')->error($e->getMessage() . ' ' . __FILE__ . ' on line = ' . __LINE__);
            return new Response();
        }
    }

    public function createDivisionFormAction(){
        return $this->render("MatrixAdminBundle:Division:divisionForm.html.twig");
    }

    public function createDivisionAction(Request $request){
        try{
            $name = $request->request->get('division-name');
            $company = $this->getUser()->getCompany();
            $version = $this->getDoctrine()->getRepository("MatrixAdminBundle:Division")->findMaxVersion();

            $division = new Division();
            $division->setName($name)
                ->setCompany($company)
                ->setVersion($version);


            $em = $this->getDoctrine()->getManager();
            $em->persist($division);
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

        return $this->forward("MatrixAdminBundle:Division:createDivisionForm");
    }

} 
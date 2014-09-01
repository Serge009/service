<?php
/**
 * Created by PhpStorm.
 * User: Matrix
 * Date: 01.09.14
 * Time: 17:33
 */

namespace Matrix\AdminBundle\Controller;


use Exception;
use Matrix\AdminBundle\Entity\Plant;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class PlantController extends Controller {

    public function getPlantsAction(){
        try{
            $plants = $this->getDoctrine()
                ->getRepository("MatrixAdminBundle:Plant")
                ->findBy(array("company" => $this->getUser()->getCompany()));

            return $this->render("MatrixAdminBundle:Plant:plants.html.twig", array("plants" => $plants));
        } catch(Exception $e){
            $this->get('logger')->error($e->getMessage() . ' ' . __FILE__ . ' on line = ' . __LINE__);
            return new Response();
        }
    }

    public function createPlantFormAction(){
        return $this->render("MatrixAdminBundle:Plant:plantForm.html.twig");
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

        return $this->forward("MatrixAdminBundle:Plant:createPlantForm");
    }

} 
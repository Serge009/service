<?php
/**
 * Created by PhpStorm.
 * User: Matrix
 * Date: 01.09.14
 * Time: 16:43
 */

namespace Matrix\AdminBundle\Controller;


use Exception;
use Matrix\AdminBundle\Entity\Services;
use Matrix\AdminBundle\Entity\Statuses;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class ServiceController extends Controller {

    public function getServicesAction(){
        try{
            $services = $this->getDoctrine()
                ->getRepository("MatrixAdminBundle:Services")
                ->findBy(array("company" => $this->getUser()->getCompany()));

            return $this->render("MatrixAdminBundle:Service:services.html.twig", array("services" => $services));
        } catch(Exception $e){
            $this->get('logger')->error($e->getMessage() . ' ' . __FILE__ . ' on line = ' . __LINE__);
            return new Response();
        }
    }

    public function createServiceFormAction(){
        $units = $this->getDoctrine()
            ->getRepository("MatrixAdminBundle:Unit")
            ->findBy(array("status" => Statuses::ACTIVE,
                "company" => $this->getUser()->getCompany()));
        return $this->render("MatrixAdminBundle:Service:serviceForm.html.twig", array("units" => $units));
    }

    public function createServiceAction(Request $request){
        try{
            $name = $request->request->get('service-name');
//            $quantity = $request->request->get('service-quantity');
            $description = $request->request->get('service-description');
            $vat = $request->request->get('service-vat');
            $code = $request->request->get('service-code');
            $unitId = $request->request->get("service-unit");

            $company = $this->getUser()->getCompany();
            $version = $this->getDoctrine()->getRepository("MatrixAdminBundle:Services")->findMaxVersion();
            $unit = $this->getDoctrine()->getRepository("MatrixAdminBundle:Unit")->findOneBy(array("id" => $unitId));

            $service = new Services();
            $service->setName($name)
                ->setDescription($description)
                ->setVat($vat)
                ->setUnit($unit)
                ->setCompany($company)
                ->setVersion($version)
                ->setStatus(Statuses::ACTIVE)
                ->setCode($code);


            $em = $this->getDoctrine()->getManager();
            $em->persist($service);
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

        return $this->forward("MatrixAdminBundle:Service:createServiceForm");
    }

    public function updateServiceFormAction($id){
        try{
            $units = $this->getDoctrine()
                ->getRepository("MatrixAdminBundle:Unit")
                ->findBy(array("status" => Statuses::ACTIVE,
                    "company" => $this->getUser()->getCompany()));

            $service = $this->getDoctrine()
                ->getRepository("MatrixAdminBundle:Services")
                ->findOneBy(array("id" => $id,
                    "company" => $this->getUser()->getCompany()));

            return $this->render("MatrixAdminBundle:Service:updateServiceForm.html.twig",
                array("units" => $units, "service" => $service));
        } catch (Exception $e){
            $this->get('logger')->error($e->getMessage() . ' ' . __FILE__ . ' on line = ' . __LINE__);
            return $this->redirect($this->generateUrl("services_list"));
        }
    }

    public function updateServiceAction(Request $request){
        try{

            $id = $request->request->get('service-id');
            $name = $request->request->get('service-name');

            $description = $request->request->get('service-description');
            $vat = $request->request->get('service-vat');
            $code = $request->request->get('service-code');
            $unitId = $request->request->get("service-unit");

            $version = $this->getDoctrine()->getRepository("MatrixAdminBundle:Services")->findMaxVersion();
            $unit = $this->getDoctrine()->getRepository("MatrixAdminBundle:Unit")->findOneBy(array("id" => $unitId));

            $service = $this->getDoctrine()->getRepository("MatrixAdminBundle:Services")->findOneBy(array("id" => $id));
            $service->setName($name)
                ->setDescription($description)
                ->setVat($vat)
                ->setUnit($unit)
                ->setVersion($version)
                ->setCode($code);


            $em = $this->getDoctrine()->getManager();
            $em->persist($service);
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

        return $this->forward("MatrixAdminBundle:Service:getServices");
    }

} 
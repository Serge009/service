<?php
/**
 * Created by PhpStorm.
 * User: Matrix
 * Date: 28.08.14
 * Time: 12:05
 */

namespace Matrix\AdminBundle\Controller;


use Matrix\AdminBundle\Entity\Licenses;
use Matrix\AdminBundle\Entity\Statuses;
use Matrix\AdminBundle\Entity\UserStatus;
use Matrix\AdminBundle\Entity\UserType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
//use Symfony\Component\BrowserKit\Request;
use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\User\User;


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
    public function createAction(Request $request) {
        try {
            $serial = $request->request->get("serial");
            $distId = $request->request->get("dist_id");
            $countUser = $request->request->get("count_user");

            $em = $this->getDoctrine();
            $dist = $em->getRepository("MatrixAdminBundle:Users")->findOneBy(array("id" => $distId));

            $license = new Licenses();
            $license->setSerial($serial)
                ->setOwner($this->getUser())
                ->setUserCount($countUser)
                ->setStatus(UserStatus::ACTIVE)
                ->setDistributor($dist);
            $em->getManager()->persist($license);
            $em->getManager()->flush();

            $this->get('session')->getFlashBag()->add(
                'notice',
                'Your changes were saved!'
            );
        }
        catch(Exception $e) {
            $this->get("logger")->error($e->getMessage() . ' ' .__FILE__ . ' on line = ' . __LINE__);

            $this->get("session")->getFlashBag()->add(
                'error',
                'Something went wrong!'
            );
        }
        return $this->forward("MatrixAdminBundle:Licenses:createForm");
    }

    public function createFormAction() {
        try {
            $bool = true;
            $massLicenses = array();
            $licenses = $this->getDoctrine()
                       ->getRepository("MatrixAdminBundle:Licenses")
                       ->findActiveLicenses();
            foreach($licenses as $license) {
                $massLicenses[] = $license->getSerial();
               }
            do {
                $generateLicense = $this->generateLicense();
                if(!in_array($generateLicense, $massLicenses)) {
                    $bool = false;
                }
            } while($bool);
            return $this->render("MatrixAdminBundle:Admin:licensesForm.html.twig", array("serial"=>$generateLicense,"licenses"=>$licenses));
        }
        catch(Exception $e) {
            $this->get("logger")->error($e->getMessage() . ' ' .__FILE__ . ' on line = ' . __LINE__);

            $this->get("session")->getFlashBag()->add(
                'error',
                'Something went wrong!'
            );
        }

    }

    public function updateFormAction($id = 0) {
        try {
            $license = $this->getDoctrine()
                ->getRepository("MatrixAdminBundle:Licenses")->findOneBy(array("id"=>$id));
            $activeDists =  $this->getDoctrine()
                ->getRepository("MatrixAdminBundle:Users")->findBy(array("type"=>UserType::DISTRIBUTOR, "status"=>Statuses::ACTIVE));
            $statuses = Statuses::getStatuses();

            return $this->render("MatrixAdminBundle:Admin:updateLicForm.html.twig", array(
                                                                                          "license"     => $license,
                                                                                          "activeDists" => $activeDists,
                                                                                          "statuses"    => $statuses));
        }
        catch(Exception $e) {
            $this->get("logger")->error($e->getMessage() . ' ' .__FILE__ . ' on line = ' . __LINE__);

            $this->get("session")->getFlashBag()->add(
                'error',
                'Something went wrong!'
            );
            return $this->redirect($this->generateUrl("licenses_list"));
        }

    }

    public function updateAction(Request $request, $id) {
        try {
        $countUser = $request->request->get("count_user");
        $status = $request->request->get("status");
        $distId = $request->request->get("dist_id");
        $em = $this->getDoctrine();

        $distributor = $em->getRepository("MatrixAdminBundle:Users")->findOneBy(array("id"=>$distId));
        $license = $em->getRepository("MatrixAdminBundle:Licenses")->findOneBy(array("id"=>$id));

        $license->setUserCount($countUser)
            ->setStatus($status)
            ->setDistributor($distributor);
        $em->getManager()->persist($license);
        $em->getManager()->flush();

            $this->get('session')->getFlashBag()->add(
                'notice',
                'Your changes were saved!'
            );
            return $this->redirect($this->generateUrl("licenses_list"));
        }
        catch(Exception $e) {
            $this->get("logger")->error($e->getMessage() . ' ' .__FILE__ . ' on line = ' . __LINE__);

            $this->get("session")->getFlashBag()->add(
                'error',
                'Something went wrong!'
            );
        }
    }

    public function generateLicense() {
        return rand(1000000000, 9999999999);
    }
} 
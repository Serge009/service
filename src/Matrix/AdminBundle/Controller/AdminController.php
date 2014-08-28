<?php
/**
 * Created by PhpStorm.
 * User: Matrix
 * Date: 27.08.14
 * Time: 15:35
 */

namespace Matrix\AdminBundle\Controller;


use Matrix\AdminBundle\Entity\UserType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class AdminController extends Controller {

    public function getDistributorsAction(){
        $distributors = $this->getDoctrine()
            ->getRepository("MatrixAdminBundle:Users")
            ->findBy(array("type" => UserType::DISTRIBUTOR));

        return $this->render("MatrixAdminBundle:Admin:dist.html.twig", array("distributors" => $distributors));
            //$this->render("MatrixAdminBundle:Admin:distributors.html.twig", array("distributors" => $distributors));
    }

} 
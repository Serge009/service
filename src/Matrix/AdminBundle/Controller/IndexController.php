<?php
/**
 * Created by PhpStorm.
 * User: Matrix
 * Date: 27.08.14
 * Time: 16:20
 */

namespace Matrix\AdminBundle\Controller;


use Matrix\AdminBundle\Entity\UserType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class IndexController extends Controller {

    public function indexAction(){

        switch($this->getUser()->getType()){
            case UserType::ADMIN:
                return $this->forward("MatrixAdminBundle:Distributors:index");
            case UserType::DISTRIBUTOR:
                return $this->forward("MatrixAdminBundle:Licenses:getByDistributor");
            default:
                return $this->redirect("login");
        }
    }

} 
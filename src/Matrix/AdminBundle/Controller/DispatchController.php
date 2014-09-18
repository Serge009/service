<?php
/**
 * Created by PhpStorm.
 * User: Matrix
 * Date: 18.09.14
 * Time: 13:07
 */

namespace Matrix\AdminBundle\Controller;


use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class DispatchController extends Controller {

    public function getDispatchesAction(){
        try{
            $dispatches = $this->getDoctrine()
                ->getRepository("MatrixAdminBundle:Dispatches")
                ->findAllByCompany($this->getUser()->getCompany());

            return $this->render("MatrixAdminBundle:Dispatch:dispatches.html.twig", array("dispatches" => $dispatches));
        } catch(Exception $e){
            $this->get('logger')->error($e->getMessage() . ' ' . __FILE__ . ' on line = ' . __LINE__);
            return new Response();
        }
    }

} 
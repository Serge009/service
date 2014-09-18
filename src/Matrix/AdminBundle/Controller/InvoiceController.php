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

class InvoiceController extends Controller {

    public function getInvoicesAction(){
        try{
            $invoices = $this->getDoctrine()
                ->getRepository("MatrixAdminBundle:Invoices")
                ->findAllByCompany($this->getUser()->getCompany());

            return $this->render("MatrixAdminBundle:Invoice:invoices.html.twig", array("invoices" => $invoices));
        } catch(Exception $e){
            $this->get('logger')->error($e->getMessage() . ' ' . __FILE__ . ' on line = ' . __LINE__);
            return new Response();
        }
    }

} 
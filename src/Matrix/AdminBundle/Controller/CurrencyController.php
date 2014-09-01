<?php
/**
 * Created by PhpStorm.
 * User: Matrix
 * Date: 01.09.14
 * Time: 17:09
 */

namespace Matrix\AdminBundle\Controller;


use Exception;
use Matrix\AdminBundle\Entity\Currency;
use Matrix\AdminBundle\Entity\Statuses;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class CurrencyController extends Controller {

    public function getCurrenciesAction(){
        try{
            $currencies = $this->getDoctrine()
                ->getRepository("MatrixAdminBundle:Currency")
                ->findBy(array("company" => $this->getUser()->getCompany()));

            return $this->render("MatrixAdminBundle:Currency:currencies.html.twig", array("currencies" => $currencies));
        } catch(Exception $e){
            $this->get('logger')->error($e->getMessage() . ' ' . __FILE__ . ' on line = ' . __LINE__);
            return new Response();
        }
    }

    public function createCurrencyFormAction(){
        return $this->render("MatrixAdminBundle:Currency:currencyForm.html.twig");
    }

    public function createCurrencyAction(Request $request){
        try{
            $name = $request->request->get('currency-name');
            $company = $this->getUser()->getCompany();
            $version = $this->getDoctrine()->getRepository("MatrixAdminBundle:Currency")->findMaxVersion();

            $currency = new Currency();
            $currency->setName($name)
                ->setCompany($company)
                ->setVersion($version)
                ->setStatus(Statuses::ACTIVE);


            $em = $this->getDoctrine()->getManager();
            $em->persist($currency);
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

        return $this->forward("MatrixAdminBundle:Currency:createCurrencyForm");
    }

} 
<?php
/**
 * Created by PhpStorm.
 * User: Matrix
 * Date: 01.09.14
 * Time: 16:56
 */

namespace Matrix\AdminBundle\Controller;


use Exception;
use Matrix\AdminBundle\Entity\Products;
use Matrix\AdminBundle\Entity\Statuses;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class ProductController extends Controller {

    public function getProductsAction(){
        try{
            $products = $this->getDoctrine()
                ->getRepository("MatrixAdminBundle:Products")
                ->findBy(array("company" => $this->getUser()->getCompany()));

            return $this->render("MatrixAdminBundle:Product:products.html.twig", array("products" => $products));
        } catch(Exception $e){
            $this->get('logger')->error($e->getMessage() . ' ' . __FILE__ . ' on line = ' . __LINE__);
            return new Response();
        }
    }

    public function createProductFormAction(){
        $units = $this->getDoctrine()
            ->getRepository("MatrixAdminBundle:Unit")
            ->findBy(array("status" => Statuses::ACTIVE,
                "company" => $this->getUser()->getCompany()));
        return $this->render("MatrixAdminBundle:Product:productForm.html.twig", array("units" => $units));
    }

    public function createProductAction(Request $request){
        try{
            $name = $request->request->get('product-name');
            $quantity = $request->request->get('product-quantity');
            $description = $request->request->get('product-description');
            $vat = $request->request->get('product-vat');
            $code = $request->request->get('product-code');
            $unitId = $request->request->get("product-unit");

            $company = $this->getUser()->getCompany();
            $version = $this->getDoctrine()->getRepository("MatrixAdminBundle:Products")->findMaxVersion();
            $unit = $this->getDoctrine()->getRepository("MatrixAdminBundle:Unit")->findOneBy(array("id" => $unitId));

            $product = new Products();
            $product->setName($name)
                ->setQuantity($quantity)
                ->setDescription($description)
                ->setVat($vat)
                ->setUnit($unit)
                ->setCompany($company)
                ->setVersion($version)
                ->setStatus(Statuses::ACTIVE)
                ->setCode($code);


            $em = $this->getDoctrine()->getManager();
            $em->persist($product);
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

        return $this->forward("MatrixAdminBundle:Product:createProductForm");
    }

} 
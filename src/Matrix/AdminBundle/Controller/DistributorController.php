<?php
/**
 * Created by PhpStorm.
 * User: Matrix
 * Date: 29.08.14
 * Time: 9:40
 */

namespace Matrix\AdminBundle\Controller;


use Exception;
use Matrix\AdminBundle\Entity\Company;
use Matrix\AdminBundle\Entity\Statuses;
use Matrix\AdminBundle\Entity\Users;
use Matrix\AdminBundle\Entity\UserStatus;
use Matrix\AdminBundle\Entity\UserType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class DistributorController extends Controller {

    public function getAccountOwnersAction(){
        try{

            $owners = $this->getDoctrine()
                ->getRepository("MatrixAdminBundle:Users")
                ->findBy(array("creator" => $this->getUser(), "type" => UserType::ACCOUNT_OWNER));

            return $this->render("MatrixAdminBundle:Distributor:owners.html.twig", array("owners" => $owners));

        } catch(Exception $e){
            $this->get('logger')->error($e->getMessage() . ' ' . __FILE__ . ' on line = ' . __LINE__);

            $this->get('session')->getFlashBag()->add(
                'error',
                'Something went wrong!'
            );

            return $this->render("MatrixAdminBundle:Distributor:owners.html.twig", array("owners" => array()));
        }
    }


    public function getLicensesAction(){
        try{

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

    public function createAccountOwnerFormAction(){
        return $this->render("MatrixAdminBundle:Distributor:ownerForm.html.twig");
    }

    public function createAccountOwnerAction(Request $request){
        try{
            $name = $request->request->get('owner-name');
            $surname = $request->request->get('owner-surname');
            $email = $request->request->get('owner-email');
            $password = $request->request->get('owner-password');
            $companyName = $request->request->get('owner-company');


            $factory = $this->get('security.encoder_factory');

            $company = new Company();
            $company->setName($companyName)
                ->setStatus(Statuses::ACTIVE);


            $user = new Users();

            $user->setSalt(Users::generateSalt());
            $encoder = $factory->getEncoder($user);
            $password = $encoder->encodePassword($password, $user->getSalt());

            $user->setPassword($password)
                ->setType(UserType::ACCOUNT_OWNER)
                ->setStatus(UserStatus::ACTIVE)
                ->setCompany($company)
                ->setEmail($email)
                ->setName($name)
                ->setSurname($surname)
                ->setCreator($this->getUser());

            $em = $this->getDoctrine()->getManager();
            $em->persist($company);
            $em->persist($user);
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

        return $this->forward("MatrixAdminBundle:Distributor:createAccountOwnerForm");
    }

} 
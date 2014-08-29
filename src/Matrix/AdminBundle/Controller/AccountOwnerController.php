<?php
/**
 * Created by PhpStorm.
 * User: Matrix
 * Date: 29.08.14
 * Time: 11:47
 */

namespace Matrix\AdminBundle\Controller;


use Exception;
use Matrix\AdminBundle\Entity\Company;
use Matrix\AdminBundle\Entity\Statuses;
use Matrix\AdminBundle\Entity\Users;
use Matrix\AdminBundle\Entity\UserStatus;
use Matrix\AdminBundle\Entity\UserType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class AccountOwnerController extends ManagerController {

    public function getManagersAction(){
        try{
            $managers = $this->getDoctrine()
                ->getRepository("MatrixAdminBundle:Users")
                ->findBy(array("type" => UserType::MANAGER,
                    "company" => $this->getUser()->getCompany()));

            return $this->render("MatrixAdminBundle:AccountOwner:managers.html.twig", array("managers" => $managers));
        } catch(Exception $e){
            $this->get('logger')->error($e->getMessage() . ' ' . __FILE__ . ' on line = ' . __LINE__);
            return new Response();
        }
    }

    public function createManagerFormAction(){
        return $this->render("MatrixAdminBundle:AccountOwner:managerForm.html.twig");
    }

    public function createManagerAction(Request $request){
        try{
            $name = $request->request->get('manager-name');
            $surname = $request->request->get('manager-surname');
            $email = $request->request->get('manager-email');
            $password = $request->request->get('manager-password');


            $factory = $this->get('security.encoder_factory');

            $company = $this->getUser()->getCompany();



            $user = new Users();

            $user->setSalt(Users::generateSalt());
            $encoder = $factory->getEncoder($user);
            $password = $encoder->encodePassword($password, $user->getSalt());

            $user->setPassword($password)
                ->setType(UserType::MANAGER)
                ->setStatus(UserStatus::ACTIVE)
                ->setCompany($company)
                ->setEmail($email)
                ->setName($name)
                ->setSurname($surname)
                ->setCreator($this->getUser());

            $em = $this->getDoctrine()->getManager();
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

        return $this->forward("MatrixAdminBundle:AccountOwner:createManagerForm");
    }

} 
<?php
/**
 * Created by PhpStorm.
 * User: Matrix
 * Date: 01.09.14
 * Time: 17:39
 */

namespace Matrix\AdminBundle\Controller;


use Exception;
use Matrix\AdminBundle\Entity\Users;
use Matrix\AdminBundle\Entity\UserStatus;
use Matrix\AdminBundle\Entity\UserType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class MobileUserController extends Controller {

    public function getMobileUsersAction(){
        try{
            $mobileUsers = $this->getDoctrine()
                ->getRepository("MatrixAdminBundle:Users")
                ->findBy(array("type" => UserType::MOBILE_USER,
                    "company" => $this->getUser()->getCompany()));

            return $this->render("MatrixAdminBundle:MobileUser:mobileUsers.html.twig", array("users" => $mobileUsers));
        } catch(Exception $e){
            $this->get('logger')->error($e->getMessage() . ' ' . __FILE__ . ' on line = ' . __LINE__);
            return new Response();
        }
    }

    public function createMobileUserFormAction(){
        return $this->render("MatrixAdminBundle:MobileUser:mobileUserForm.html.twig");
    }

    public function createMobileUserAction(Request $request){
        try{
            $name = $request->request->get('m-user-name');
            $surname = $request->request->get('m-user-surname');
            $email = $request->request->get('m-user-email');
            $password = $request->request->get('m-user-password');


            $factory = $this->get('security.encoder_factory');

            $company = $this->getUser()->getCompany();



            $user = new Users();

            $user->setSalt(Users::generateSalt());
            $encoder = $factory->getEncoder($user);
            $password = $encoder->encodePassword($password, $user->getSalt());

            $user->setPassword($password)
                ->setType(UserType::MOBILE_USER)
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

        return $this->forward("MatrixAdminBundle:MobileUser:createMobileUserForm");
    }

} 
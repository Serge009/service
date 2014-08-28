<?php
/**
 * Created by PhpStorm.
 * User: Matrix
 * Date: 28.08.14
 * Time: 10:31
 */

namespace Matrix\AdminBundle\Controller;


use Exception;
use Matrix\AdminBundle\Entity\UserType;
use Matrix\AdminBundle\Entity\Users;
use Matrix\AdminBundle\Entity\UserStatus;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class DistributorsController extends Controller {

    public function indexAction(){
        try{
            $distributors = $this->getDoctrine()
                ->getRepository("MatrixAdminBundle:Users")
                ->findBy(array("type" => UserType::DISTRIBUTOR));

            return $this->render("MatrixAdminBundle:Admin:dist.html.twig", array("distributors" => $distributors));
        } catch(Exception $e){
            $this->get('logger')->error($e->getMessage() . ' ' . __FILE__ . ' on line = ' . __LINE__);
            return new Response();
        }
    }

    public function createFormAction(){
        return $this->render("MatrixAdminBundle:Admin:distForm.html.twig");
    }

    public function createAction(Request $request){
        try{
            $name = $request->request->get('dist-name');
            $surname = $request->request->get('dist-surname');
            $email = $request->request->get('dist-email');
            $password = $request->request->get('dist-password');


            $factory = $this->get('security.encoder_factory');
            $user = new Users();

            $user->setSalt(Users::generateSalt());
            $encoder = $factory->getEncoder($user);
            $password = $encoder->encodePassword($password, $user->getSalt());

            $user->setPassword($password)
                ->setType(UserType::DISTRIBUTOR)
                ->setStatus(UserStatus::ACTIVE)
                ->setCompany($this->getUser()->getCompany())
                ->setEmail($email)
                ->setName($name)
                ->setSurname($surname);

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

        return $this->forward("MatrixAdminBundle:Admin:createForm");
    }

} 
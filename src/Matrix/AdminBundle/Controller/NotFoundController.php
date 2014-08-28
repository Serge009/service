<?php
/**
 * Created by PhpStorm.
 * User: SERGE
 * Date: 16.08.14
 * Time: 19:40
 */

namespace Matrix\AdminBundle\Controller;


use Matrix\AdminBundle\Entity\Users;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class NotFoundController extends Controller{

    public function indexAction(){

        $factory = $this->get('security.encoder_factory');
        $user = new Users();//$this->getDoctrine()->getRepository("MatrixAdminBundle:Users")->findOneBy(array("id" => 1));

        $user->setSalt(Users::generateSalt());
        $encoder = $factory->getEncoder($user);
        $password = $encoder->encodePassword('test', $user->getSalt());
        echo strlen($password);
        $user->setPassword($password);

        var_dump($user);
        return new Response("Not Found<body></body>");
    }

} 
<?php
/**
 * Created by PhpStorm.
 * User: Matrix
 * Date: 27.08.14
 * Time: 9:38
 */

namespace Matrix\AdminBundle\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class LoginController extends Controller {

    public function indexAction(){
        return new Response("Login:index");
    }

} 
<?php
/**
 * Created by PhpStorm.
 * User: SERGE
 * Date: 16.08.14
 * Time: 19:40
 */

namespace Matrix\AdminBundle\Controller;


use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class NotFoundController extends Controller{

    public function indexAction(){

        var_dump($this->getUser());
        return new Response("Not Found<body></body>");
    }

} 
<?php
/**
 * Created by PhpStorm.
 * User: SERGE
 * Date: 16.08.14
 * Time: 19:40
 */

namespace Matrix\ServiceBundle\Controller;


use Matrix\ServiceBundle\Utils\Errors;
use Symfony\Component\HttpFoundation\Response;

class NotFoundController extends AppController{

    public function indexAction(){


        return $this->renderError(Errors::INCORRECT_REQUEST);
    }

} 
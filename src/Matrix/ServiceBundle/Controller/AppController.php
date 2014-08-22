<?php
/**
 * Created by PhpStorm.
 * User: SERGE
 * Date: 16.08.14
 * Time: 19:32
 */

namespace Matrix\ServiceBundle\Controller;

use Exception;
use Matrix\ServiceBundle\Entity\Sessions;
use Matrix\ServiceBundle\Entity\Statuses;
use Matrix\ServiceBundle\Utils\Errors;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;


/**
 * @class AppController
 * basic controller for application
 */

abstract class AppController extends Controller {

    //TODO: remove in "real world"
    public static $isDevMode = false;

    private $resp = array(
        "error" => array(
            "code" => 0,
            "msg" => ""
        ),

        "data" => array(
            "session" => null
        )
    );

    private $error = array(
                            "code" => 0,
                            "msg" => ""
                        );

    private $data =array(
                            "default" => 0
                        );


    public function setError($error){
        $this->resp['error'] =  Errors::getMsg($error);
        //$this->error =  Errors::getMsg($error);
    }

    public function setData(array $data){
        //$this->data = $data;
        $this->resp['data'] = $data;
    }

    public function renderError($error){
        $this->setError($error);

        if(self::$isDevMode){
            return new Response("<body></body>" . json_encode($this->resp));
        }

        return new Response(json_encode($this->resp));
        //return $this->render("MatrixServiceBundle:Default:404.html.twig", array("error" => $this->error, "data" => json_encode($this->data)));
    }

    public function renderData(array $data){
        $this->setData($data);

        if(self::$isDevMode){
            return new Response("<body></body>" . json_encode($this->resp));
        }

        return new Response(json_encode($this->resp));
        //return $this->render("MatrixServiceBundle:Default:404.html.twig", array("error" => $this->error, "data" => json_encode($this->data)));
    }

    /**
     * @param $sessionId
     * @return false | Sessions
     */
    public function isSessionValid($sessionId){
        $session = $this->getDoctrine()->getRepository("MatrixServiceBundle:Sessions")
            ->findOneBy(array("sessionId" => $sessionId, "status" => Statuses::ACTIVE));

        if($session && $session->getDevice()->getStatus() == Statuses::ACTIVE
            && $session->getDevice()->getUser()->getStatus() == Statuses::ACTIVE
            && $session->getDevice()->getUser()->getCompany()->getStatus() == Statuses::ACTIVE
            && $session->getDevice()->getLicense()->getStatus() == Statuses::ACTIVE){

            return $session;

        }

        return false;
    }

    protected function toArray(array $data){

        try{
            $res = array();
            foreach($data as $item){
                array_push($res, $item->toArray());
            }

            return $res;
        } catch(Exception $e){
            return array();
        }

    }

}
<?php

namespace Matrix\ServiceBundle\Controller;

use Exception;
use Matrix\ServiceBundle\Utils\Errors;
use Symfony\Component\HttpFoundation\Request;

class LogoutController extends AppController
{
    public function indexAction(Request $request)
    {
        try{
            $data = json_decode($request->request->get('data'));

            if(!$data){
                return $this->renderError(Errors::INCORRECT_REQUEST);
            }

            return $this->logout($data);
        } catch(Exception $e){
            $this->get('logger')->error($e->getMessage() . ' ' . __FILE__ . ' on line = ' . __LINE__);
            return $this->renderError(Errors::INCORRECT_REQUEST);
        }
    }

    private function logout(\stdClass $data){
        //var_dump($data);
        $license = $data->license;
        $uuid = $data->uuid;

        if(!$license || !$uuid) throw new Exception();

        $repository  = $this->getDoctrine()->getRepository("MatrixServiceBundle:Sessions");
        $res = $repository->closeAllSessions($license, $uuid);

        if($res){
            return $this->renderData(array("session" => null));
        }


        return $this->renderError(Errors::INCORRECT_REQUEST);
    }
}

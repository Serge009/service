<?php
/**
 * Created by PhpStorm.
 * User: SERGE
 * Date: 17.08.14
 * Time: 15:46
 */

namespace Matrix\ServiceBundle\Controller;


use Exception;
use Matrix\ServiceBundle\Entity\Company;
use Matrix\ServiceBundle\Utils\Errors;
use Symfony\Component\HttpFoundation\Request;

class ItemsController extends AppController {

    public function indexAction(Request $request){
        try{
            $data = json_decode($request->request->get('data'));

            if(!$data || !$session = $this->isSessionValid($data->session)){
                return $this->renderError(Errors::INCORRECT_REQUEST);
            }

            //return $this->getCustomersList($session);

        } catch(Exception $e){
            $this->get('logger')->error($e->getMessage() . ' ' . __FILE__ . ' on line = ' . __LINE__);
            return $this->renderError(Errors::INCORRECT_REQUEST);
        }
    }

    private function getSesvicesList(Company $company){

    }


} 
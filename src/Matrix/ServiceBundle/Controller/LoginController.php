<?php
/**
 * Created by PhpStorm.
 * User: SERGE
 * Date: 16.08.14
 * Time: 20:00
 */

namespace Matrix\ServiceBundle\Controller;


use Exception;
use Matrix\ServiceBundle\Entity\Devices;
use Matrix\ServiceBundle\Entity\Sessions;
use Matrix\ServiceBundle\Entity\Statuses;
use Matrix\ServiceBundle\Utils\Errors;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Matrix\ServiceBundle\Entity\Users;

class LoginController extends AppController {

    /**
     * @var Users
     */
    private $user;

    public function indexAction(Request $request){
        try{
            $data = json_decode($request->request->get('data'));

            if(!$data){
                return $this->renderError(Errors::INCORRECT_REQUEST);
            }

            return $this->login($data);
        } catch(Exception $e){
            $this->get('logger')->error($e->getMessage() . ' ' . __FILE__ . ' on line = ' . __LINE__);
            return $this->renderError(Errors::INCORRECT_REQUEST);
        }
    }

    private function login(\stdClass $data){
        try{

            $email = $data->email;
            $pass  = $data->password;
            $license = $data->license;
            $uuid = $data->uuid;

            return $this->authorize($email, $pass, $license, $uuid);

        } catch(Exception $e){
            $this->get('logger')->error($e->getMessage() . ' ' . __FILE__ . ' on line = ' . __LINE__);
            return $this->renderError(Errors::INCORRECT_REQUEST);
        }
    }

    private function authorize($email, $pass, $license, $uuid){
        $repository = $this->getDoctrine()->getRepository('MatrixServiceBundle:Users');
        $this->user = $repository->findOneBy(array("email" => $email));



        $factory = $this->get('security.encoder_factory');

        $user = new Users();
        $user->setSalt($this->user->getSalt());

        $encoder = $factory->getEncoder($user);
        $password = $encoder->encodePassword($pass, $user->getSalt());


        $user->setEmail($email)
            ->setPassword($password);


        if($this->user->equals($user)) {
            return $this->checkLicense($license, $uuid);
        }

        return $this->renderError(Errors::INCORRECT_LOIN_INFO);
    }

    private function checkLicense($license, $uuid){
        $repository = $this->getDoctrine()->getRepository('MatrixServiceBundle:Licenses');
        $valid = $repository->isLicenseValid($license, $uuid);

        if(!$valid){
            return $this->checkLicenseCount($license, $uuid);
        }

        $repository = $this->getDoctrine()->getRepository('MatrixServiceBundle:Devices');
        $device = $repository->findOneByLicenseAndUUID($license, $uuid);

        return $this->createSession($device);
    }

    private function checkLicenseCount($license, $uuid){
        $repository = $this->getDoctrine()->getRepository('MatrixServiceBundle:Licenses');
        $valid = $repository->checkLicenseCount($license);

        if($valid){
            return $this->createNewDevice($uuid, $license);
        }

        return $this->renderError(Errors::INCORRECT_LICENSE_COUNT);
    }

    private function createNewDevice($uuid, $serial){
        $repository = $this->getDoctrine()->getRepository('MatrixServiceBundle:Devices');
        $info = $repository->createNewDevice($uuid, $serial, $this->user->getId());

        if($info){
            return $this->createSession($info['device']);
        }

        $this->get('logger')->error($uuid . " " .$serial ." " . $this->user->getId() );
        return $this->renderError(Errors::OOPS);
    }

    private function createSession(Devices $device){
        $repository = $this->getDoctrine()->getRepository('MatrixServiceBundle:Sessions');
        $session = $repository->findOneBy(array("device" => $device, "status" => Statuses::ACTIVE));

        if(!$session){
            $sessionId = md5(time());

            $session = new Sessions();
            $session->setStatus(Statuses::ACTIVE)
                ->setDevice($device)
                ->setSessionId($sessionId);

            $em = $this->getDoctrine()->getManager();

            $em->persist($session);
            $em->flush();
        }

        return $this->renderData(array("session" => $session->getSessionId()));
    }

} 
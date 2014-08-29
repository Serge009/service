<?php
/**
 * Created by PhpStorm.
 * User: SERGE
 * Date: 17.08.14
 * Time: 11:22
 */

namespace Matrix\AdminBundle\Repository;


use Doctrine\ORM\EntityRepository;
use Matrix\AdminBundle\Entity\Statuses;

class SessionsRepository extends EntityRepository {

    public function closeAllSessions($serial, $uuid){

        $em = $this->getEntityManager();

        $license = $em->getRepository("MatrixServiceBundle:Licenses")
            ->findOneBy(array("serial" => $serial));

        $device = $em->getRepository("MatrixServiceBundle:Devices")
            ->findOneBy(array("uuid" => $uuid, "license" => $license));

        $sessions = $em->getRepository("MatrixServiceBundle:Sessions")
            ->findBy(array("device" => $device));

        foreach($sessions as $session){
            $session->setStatus(Statuses::DELETED);
            $em->persist($session);
        }

        $em->flush();

        return true;

    }

} 
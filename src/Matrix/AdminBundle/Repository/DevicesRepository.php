<?php
/**
 * Created by PhpStorm.
 * User: SERGE
 * Date: 16.08.14
 * Time: 20:20
 */

namespace Matrix\AdminBundle\Repository;


use Doctrine\ORM\EntityRepository;
use Exception;
use Matrix\ServiceBundle\Entity\Devices;

class DevicesRepository extends EntityRepository
{
    public function createNewDevice($uuid, $serial, $userId){

        try{

            if(!$uuid || !$serial || !$userId)
                throw new Exception("create new device - EMPTY FIELD");

            $em = $this->getEntityManager();

            $license = $em->getRepository("MatrixServiceBundle:Licenses")
                ->findOneBy(array("serial" => $serial));

            $user = $em->getRepository("MatrixServiceBundle:Users")
                ->findOneBy(array("id" => $userId));

            $device = new Devices();
            $device->setLicense($license)
                ->setUser($user)
                ->setUuid($uuid);

            $em->persist($device);
            $em->flush();

            return array("device" => $device,
                        "license" => $license,
                        "user"   => $user);

        } catch(Exception $e){
            return false;
        }

    }


    public function findOneByLicenseAndUUID($serial, $uuid){
        $em = $this->getEntityManager();

        $license = $em->getRepository("MatrixServiceBundle:Licenses")
            ->findOneBy(array("serial" => $serial));

        $device = $em->getRepository("MatrixServiceBundle:Devices")
            ->findOneBy(array("uuid" => $uuid, "license" => $license));

        return $device;
    }


}
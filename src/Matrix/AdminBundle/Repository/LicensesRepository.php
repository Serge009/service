<?php
/**
 * Created by PhpStorm.
 * User: SERGE
 * Date: 16.08.14
 * Time: 20:20
 */

namespace Matrix\AdminBundle\Repository;


use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Query\ResultSetMapping;

class LicensesRepository extends EntityRepository
{
    public function isLicenseValid($license, $uuid){

        $rsm = new ResultSetMapping();
        $rsm->addScalarResult("res", "count");

        $query = $this->getEntityManager()
            ->createNativeQuery('SELECT COUNT(devices.id) AS res  FROM devices,
             (SELECT id FROM licenses WHERE serial = ?) AS l
             WHERE license = l.id AND uuid = ?', $rsm)

            ->setParameter(1, $license)
            ->setParameter(2, $uuid);


        $count = $query->getResult();
        //var_dump($count);
        return (!empty($count) && intval($count[0]['count']) > 0) ? true : false;

    }

    public function checkLicenseCount($license){

        $rsm = new ResultSetMapping();
        $rsm->addScalarResult("res", "count");

        $query = $this->getEntityManager()
            ->createNativeQuery('SELECT (lic.user_count - dev.res) AS res
                    FROM licenses AS lic,
                    (SELECT COUNT(devices.id) AS res FROM devices,
                    (SELECT id FROM licenses WHERE serial = ?) AS l
                    WHERE license = l.id) AS dev
                    WHERE serial = ?', $rsm)

            ->setParameter(1, $license)
            ->setParameter(2, $license);


        $count = $query->getResult();
        //var_dump($count);
        return (!empty($count) && intval($count[0]['count']) > 0) ? true : false;

    }
}
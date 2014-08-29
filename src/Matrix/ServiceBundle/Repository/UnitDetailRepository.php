<?php
/**
 * Created by PhpStorm.
 * User: Matrix
 * Date: 28.08.14
 * Time: 17:06
 */

namespace Matrix\ServiceBundle\Repository;


use Doctrine\ORM\EntityRepository;
use Matrix\ServiceBundle\Entity\Company;

class UnitDetailRepository extends EntityRepository {

    public function findByVersion($version, Company $company){

        $em = $this->getEntityManager();
        $qb = $em->createQueryBuilder();
        $qb->select('ud')
            ->from('Matrix\ServiceBundle\Entity\UnitDetail' , "ud")
            ->innerJoin('Matrix\ServiceBundle\Entity\Unit', "u")
            ->where("ud.version > :version")
            ->andWhere("u.company = :company")
            ->setParameter("version", $version)
            ->setParameter("company", $company);


        return $qb->getQuery()->execute();

    }

} 
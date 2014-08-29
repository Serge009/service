<?php
/**
 * Created by PhpStorm.
 * User: Matrix
 * Date: 28.08.14
 * Time: 17:39
 */

namespace Matrix\ServiceBundle\Repository;


use Doctrine\ORM\EntityRepository;
use Matrix\ServiceBundle\Entity\Company;

class ServicePricesRepository extends EntityRepository {

    public function findByVersion($version, Company $company){

        $em = $this->getEntityManager();
        $qb = $em->createQueryBuilder();
        $qb->select('sp')
            ->from('Matrix\ServiceBundle\Entity\ServicePrices' , "sp")
            ->innerJoin('Matrix\ServiceBundle\Entity\Services', "s")
            ->where("sp.version > :version")
            ->andWhere("s.company = :company")
            ->setParameter("version", $version)
            ->setParameter("company", $company);


        return $qb->getQuery()->execute();

    }

} 
<?php
/**
 * Created by PhpStorm.
 * User: Matrix
 * Date: 28.08.14
 * Time: 15:33
 */

namespace Matrix\ServiceBundle\Repository;


use Doctrine\ORM\EntityRepository;
use Matrix\ServiceBundle\Entity\Company;

class CurrencyRepository extends EntityRepository {

    public function findByVersion($version, Company $company){

        $em = $this->getEntityManager();
        $qb = $em->createQueryBuilder();
        $qb->select('c')
            ->from('Matrix\ServiceBundle\Entity\Currency' , "c")
            ->where("c.version > :version")
            ->andWhere("c.company = :company")
            ->setParameter("version", $version)
            ->setParameter("company", $company);


        return $qb->getQuery()->execute();

    }
}
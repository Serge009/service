<?php
/**
 * Created by PhpStorm.
 * User: Matrix
 * Date: 18.08.14
 * Time: 11:19
 */

namespace Matrix\ServiceBundle\Repository;


use Doctrine\ORM\EntityRepository;
use Matrix\ServiceBundle\Entity\Company;
use Matrix\ServiceBundle\Entity\Statuses;

class CustomersRepository extends EntityRepository {

    public function findByVersion($version, Company $company){

        $em = $this->getEntityManager();
        $qb = $em->createQueryBuilder();
        $qb->select('c')
            ->from('Matrix\ServiceBundle\Entity\Customers' , "c")
            ->where("c.version > :version")
            ->andWhere("c.company = :company")
            ->setParameter("version", $version)
            ->setParameter("company", $company);


        return $qb->getQuery()->execute();

    }

} 
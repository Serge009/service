<?php
/**
 * Created by PhpStorm.
 * User: SERGE
 * Date: 17.08.14
 * Time: 16:58
 */

namespace Matrix\ServiceBundle\Repository;


use Doctrine\ORM\EntityRepository;
use Matrix\ServiceBundle\Entity\Company;

class ProductsRepository extends EntityRepository {

    public function findByVersion($version, Company $company){

        $em = $this->getEntityManager();
        $qb = $em->createQueryBuilder();
        $qb->select('p')
            ->from('Matrix\ServiceBundle\Entity\Products' , "p")
            ->where("p.version > :version")
            ->andWhere("p.company = :company")
            ->setParameter("version", $version)
            ->setParameter("company", $company);


        return $qb->getQuery()->execute();

    }

} 
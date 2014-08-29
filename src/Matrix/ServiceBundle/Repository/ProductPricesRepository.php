<?php
/**
 * Created by PhpStorm.
 * User: Matrix
 * Date: 28.08.14
 * Time: 17:41
 */

namespace Matrix\ServiceBundle\Repository;


use Doctrine\ORM\EntityRepository;
use Matrix\ServiceBundle\Entity\Company;

class ProductPricesRepository extends EntityRepository{

    public function findByVersion($version, Company $company){

        $em = $this->getEntityManager();
        $qb = $em->createQueryBuilder();
        $qb->select('pp')
            ->from('Matrix\ServiceBundle\Entity\ProductPrices' , "pp")
            ->innerJoin('Matrix\ServiceBundle\Entity\Products', "p")
            ->where("pp.version > :version")
            ->andWhere("p.company = :company")
            ->setParameter("version", $version)
            ->setParameter("company", $company);


        return $qb->getQuery()->execute();

    }

} 
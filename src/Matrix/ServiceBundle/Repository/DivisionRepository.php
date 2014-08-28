<?php
/**
 * Created by PhpStorm.
 * User: Matrix
 * Date: 28.08.14
 * Time: 15:46
 */

namespace Matrix\ServiceBundle\Repository;


use Doctrine\ORM\EntityRepository;
use Matrix\ServiceBundle\Entity\Company;

class DivisionRepository extends EntityRepository {

    public function findByVersion($version, Company $company){

        $em = $this->getEntityManager();
        $qb = $em->createQueryBuilder();
        $qb->select('d')
            ->from('Matrix\ServiceBundle\Entity\Division' , "d")
            ->where("d.version > :version")
            ->andWhere("d.company = :company")
            ->setParameter("version", $version)
            ->setParameter("company", $company);


        return $qb->getQuery()->execute();

    }

} 
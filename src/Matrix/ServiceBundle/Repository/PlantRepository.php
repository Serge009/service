<?php
/**
 * Created by PhpStorm.
 * User: Matrix
 * Date: 28.08.14
 * Time: 15:48
 */

namespace Matrix\ServiceBundle\Repository;


use Doctrine\ORM\EntityRepository;
use Matrix\ServiceBundle\Entity\Company;

class PlantRepository extends EntityRepository {

    public function findByVersion($version, Company $company){

        $em = $this->getEntityManager();
        $qb = $em->createQueryBuilder();
        $qb->select('p')
            ->from('Matrix\ServiceBundle\Entity\Plant' , "p")
            ->where("p.version > :version")
            ->andWhere("p.company = :company")
            ->setParameter("version", $version)
            ->setParameter("company", $company);


        return $qb->getQuery()->execute();

    }

} 
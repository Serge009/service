<?php
/**
 * Created by PhpStorm.
 * User: Matrix
 * Date: 11.09.14
 * Time: 12:52
 */

namespace Matrix\ServiceBundle\Repository;


use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Query\ResultSetMapping;
use Matrix\ServiceBundle\Entity\Users;

class InvoicesRepository extends EntityRepository {

    public function findMaxVersion(){
        $rsm = new ResultSetMapping();
        $rsm->addScalarResult("res", "count");

        $query = $this->getEntityManager()
            ->createNativeQuery('SELECT MAX(version)+1 AS res FROM invoices', $rsm);


        $count = $query->getResult();
        //var_dump($count);
        return (!empty($count) && intval($count[0]['count']) > 0) ? intval($count[0]['count']) : 1;
    }


    public function findByVersion($version, Users $user){

        $em = $this->getEntityManager();
        $qb = $em->createQueryBuilder();
        $qb->select('o')
            ->from('Matrix\ServiceBundle\Entity\Invoices' , "o")
            ->where("o.version > :version")
            ->andWhere("o.user = :user")
            ->setParameter("version", $version)
            ->setParameter("user", $user);


        return $qb->getQuery()->execute();

    }
} 
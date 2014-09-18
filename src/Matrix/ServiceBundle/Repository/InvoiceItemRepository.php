<?php
/**
 * Created by PhpStorm.
 * User: Matrix
 * Date: 11.09.14
 * Time: 12:53
 */

namespace Matrix\ServiceBundle\Repository;


use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Query\ResultSetMapping;
use Matrix\ServiceBundle\Entity\Users;

class InvoiceItemRepository extends EntityRepository{

    public function findMaxVersion(){

        $rsm = new ResultSetMapping();
        $rsm->addScalarResult("res", "count");

        $query = $this->getEntityManager()
            ->createNativeQuery('SELECT MAX(version)+1 AS res FROM invoice_item', $rsm);


        $count = $query->getResult();
        //var_dump($count);
        return (!empty($count) && intval($count[0]['count']) > 0) ? intval($count[0]['count']) : 1;
    }

    public function findByVersion($version, Users $user){

        $em = $this->getEntityManager();
        $qb = $em->createQueryBuilder();
        $qb->select('oi')
            ->from('Matrix\ServiceBundle\Entity\InvoiceItem' , "oi")
            ->innerJoin('oi.invoice', "o")
            ->where("oi.version > :version")
            ->andWhere("o.user = :user")
            ->setParameter("version", $version)
            ->setParameter("user", $user);


        return $qb->getQuery()->execute();

    }
} 
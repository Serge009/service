<?php
/**
 * Created by PhpStorm.
 * User: Matrix
 * Date: 06.10.14
 * Time: 12:55
 */

namespace Matrix\ServiceBundle\Repository;


use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Query\ResultSetMapping;
use Matrix\ServiceBundle\Entity\Users;

class CreditCardPaymentRepository extends EntityRepository {
    public function findMaxVersion(){
        $rsm = new ResultSetMapping();
        $rsm->addScalarResult("res", "count");

        $query = $this->getEntityManager()
            ->createNativeQuery('SELECT MAX(version)+1 AS res FROM credit_card_payment', $rsm);


        $count = $query->getResult();
        //var_dump($count);
        return (!empty($count) && intval($count[0]['count']) > 0) ? intval($count[0]['count']) : 1;
    }


    public function findByVersion($version, Users $user){

        $em = $this->getEntityManager();
        $qb = $em->createQueryBuilder();
        $qb->select('o')
            ->from('Matrix\ServiceBundle\Entity\CreditCardPayment' , "o")
            ->where("o.version > :version")
            ->andWhere("o.mobileUser = :user")
            ->setParameter("version", $version)
            ->setParameter("user", $user);


        return $qb->getQuery()->execute();

    }
} 
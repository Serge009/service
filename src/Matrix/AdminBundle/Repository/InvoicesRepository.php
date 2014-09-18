<?php
/**
 * Created by PhpStorm.
 * User: Matrix
 * Date: 18.08.14
 * Time: 16:37
 */

namespace Matrix\AdminBundle\Repository;


use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Query\ResultSetMapping;
use Matrix\AdminBundle\Entity\Company;

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

    public function findAllByCompany(Company $company){
        $em = $this->getEntityManager();
        $qb = $em->createQueryBuilder();
        $qb->select('o')
            ->from('Matrix\AdminBundle\Entity\Invoices' , "o")
            ->innerJoin("o.user", "u")
            ->where("u.company = :company")
            ->setParameter("company", $company);



        return $qb->getQuery()->execute();
    }


} 
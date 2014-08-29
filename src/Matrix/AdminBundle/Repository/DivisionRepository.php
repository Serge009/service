<?php
/**
 * Created by PhpStorm.
 * User: Matrix
 * Date: 29.08.14
 * Time: 15:08
 */

namespace Matrix\AdminBundle\Repository;


use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Query\ResultSetMapping;

class DivisionRepository extends EntityRepository {

    public function findMaxVersion(){
        $rsm = new ResultSetMapping();
        $rsm->addScalarResult("res", "count");

        $query = $this->getEntityManager()
            ->createNativeQuery('SELECT MAX(version)+1 AS res FROM division', $rsm);


        $count = $query->getResult();
        //var_dump($count);
        return (!empty($count) && intval($count[0]['count']) > 0) ? intval($count[0]['count']) : 1;
    }

} 
<?php
/**
 * Created by PhpStorm.
 * User: SERGE
 * Date: 16.08.14
 * Time: 20:20
 */

namespace Matrix\ServiceBundle\Repository;


use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Query\ResultSetMapping;
use Matrix\ServiceBundle\Entity\Statuses;
use Matrix\ServiceBundle\Entity\UserStatus;
use Matrix\ServiceBundle\Entity\UserType;

class UsersRepository extends EntityRepository
{
    public function findAllByEmail($email, $pass){



        $rsm = new ResultSetMapping();
        $rsm->addScalarResult("id", "id");
/*
        $rsm->addEntityResult('Matrix\ServiceBundle\Entity\Users', 'u');
        $rsm->addFieldResult('u', "id", "id");
        $rsm->addFieldResult('u', "name", "name");
        $rsm->addFieldResult('u', "surname", "surname");
        $rsm->addFieldResult('u', "email", "email");
        $rsm->addJoinedEntityResult('Matrix\ServiceBundle\Entity\Company' , 'c', 'u', 'company');
        $rsm->addFieldResult('c', "company_id", "id");
        $rsm->addFieldResult('c', "company_name", "name");

*/
        $query = $this->getEntityManager()
            ->createNativeQuery('SELECT u.id FROM users u
                            INNER JOIN company c
                            ON u.company = c.id
                            WHERE u.type = ?
                            AND u.status = ?
                            AND u.email = ?
                            AND u.password = MD5(CONCAT(u.salt, MD5(?)))
                            AND c.status = ?', $rsm)

            ->setParameter(1, UserType::MOBILE_USER)
            ->setParameter(2, UserStatus::ACTIVE)
            ->setParameter(3, $email)
            ->setParameter(4, $pass)
            ->setParameter(5, Statuses::ACTIVE);


        $user = $query->getResult();

        return count($user) > 0 ? $user[0] : false;

    }
}
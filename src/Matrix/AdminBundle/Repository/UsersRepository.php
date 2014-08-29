<?php
/**
 * Created by PhpStorm.
 * User: SERGE
 * Date: 16.08.14
 * Time: 20:20
 */

namespace Matrix\AdminBundle\Repository;


use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\NoResultException;
use Doctrine\ORM\Query\ResultSetMapping;
use Matrix\AdminBundle\Entity\Statuses;
use Matrix\AdminBundle\Entity\UserStatus;
use Matrix\AdminBundle\Entity\UserType;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Symfony\Component\Security\Core\Exception\UsernameNotFoundException;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Core\User\UserInterface;

class UsersRepository extends EntityRepository implements UserProviderInterface
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

    public function loadUserByUsername($username)
    {
        $q = $this
            ->createQueryBuilder('u')
            ->where('u.email = :email')
            ->andWhere('status = :status')
            ->setParameter('status', Statuses::ACTIVE)
            ->setParameter('email', $username)
            ->getQuery();

        try {
            // The Query::getSingleResult() method throws an exception
            // if there is no record matching the criteria.
            $user = $q->getSingleResult();
        } catch (NoResultException $e) {
            $message = sprintf(
                'Unable to find an active admin AcmeUserBundle:User object identified by "%s".',
                $username
            );
            throw new UsernameNotFoundException($message, 0, $e);
        }

        var_dump($user);
        return $user;
    }

    public function refreshUser(UserInterface $user)
    {
        $class = get_class($user);
        if (!$this->supportsClass($class)) {
            throw new UnsupportedUserException(
                sprintf(
                    'Instances of "%s" are not supported.',
                    $class
                )
            );
        }

        return $this->find($user->getId());
    }

    public function supportsClass($class)
    {
        return $this->getEntityName() === $class
        || is_subclass_of($class, $this->getEntityName());
    }
}
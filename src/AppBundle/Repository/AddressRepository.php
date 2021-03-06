<?php

namespace AppBundle\Repository;

use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Security\User\UserLoaderInterface;

class AddressRepository extends EntityRepository
{
    public function findAllBySalonId($salonId)
    {
        $query = $this->getEntityManager()
            ->createQuery('
                    SELECT a FROM AppBundle\Entity\Address a
                    JOIN a.salons s
                    WHERE a.id = :id
            ')->setParameter('id', $salonId);

        return $query->getResult();
    }
}
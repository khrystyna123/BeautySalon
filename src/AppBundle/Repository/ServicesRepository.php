<?php

namespace AppBundle\Repository;

use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Security\User\UserLoaderInterface;

class ServicesRepository extends EntityRepository
{
    public function findAllBySalonId($salonId)
    {
        $query = $this->getEntityManager()
            ->createQuery('
                SELECT c
                FROM AppBundle\Entity\salons_services s
                JOIN s.salons b
                WHERE b.id = :id
        ')->setParameter('id', $salonId);

        return $query->getResult();
    }

}
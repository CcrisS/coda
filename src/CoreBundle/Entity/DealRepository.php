<?php

namespace CoreBundle\Entity;

use Doctrine\ORM\EntityRepository;

/**
 * DealRepository
 *
 */
class DealRepository extends EntityRepository
{
    /**
     * @return array
     */
    public function queryFilter()
    {
        $qb = $this->getEntityManager()->createQueryBuilder();
        $qb
            ->add('select', 'd, n')
            ->add('from', 'CoreBundle:Deal d JOIN d.nodes n')
            ->add('orderBy', 'n.level ASC')
        ;

        return $qb->getQuery()->getResult();
    }

    /**
     * @return array
     */
    public function find($id)
    {
        $qb = $this->getEntityManager()->createQueryBuilder();
        $qb
            ->add('select', 'd, n')
            ->add('from', 'CoreBundle:Deal d JOIN d.nodes n')
            ->add('where', 'd.id = :id')->setParameter('id', $id)
            ->add('orderBy', 'n.level ASC')
        ;

        return $qb->getQuery()->getSingleResult();

    }
}

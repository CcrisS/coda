<?php

namespace CoreBundle\Entity;

use Doctrine\ORM\EntityRepository;

/**
 * ConnectionRepository
 *
 */
class ConnectionRepository extends EntityRepository
{
	/**
     * @param array $criteria
     * @return array
     */
    public function queryFilter($criteria = array())
    {
        $qb = $this->getEntityManager()->createQueryBuilder();
        $qb->add('select', 'c, ic')->add('from', 'CoreBundle:Connection c JOIN c.initialCompany ic')->add('orderBy', 'c.isProvider DESC');

        if(!is_null($criteria)){
            if(array_key_exists('id', $criteria) && !empty($criteria['id'])){
                $qb->andWhere('o.id = :id')->setParameter('id', $criteria['id']);
            }
            if(array_key_exists('company', $criteria) && !empty($criteria['company']) && $company = $criteria['company']){
                $criteria['company_id'] = $company->getId();
            }
            if(array_key_exists('company_id', $criteria) && !empty($criteria['company_id'])){
                $qb->andWhere('c.initialCompany = :company_id or c.endCompany = :company_id')->setParameter('company_id', $criteria['company_id']);
            }
            if(array_key_exists('type', $criteria) && !is_null($criteria['type'])){
                $qb->andWhere('c.isProvider = :type')->setParameter('type', $criteria['type']);
            }
        }

        // return $qb->getQuery()->getResult();
        return $qb->getQuery();
    }
}

<?php

namespace ProductsBundle\Repository;

/**
 * history_biddingRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class history_biddingRepository extends \Doctrine\ORM\EntityRepository
{
    public function getlastBid($id){
        $qb = $this->createQueryBuilder('i');

        $qb
            ->where('i.product = :id')
            ->setParameter('id', $id)
            ->setMaxResults( 1 )
            ->select('i.bid')
            ->orderBy('i.bid','DESC');


       return  $qb->getQuery()->getOneOrNullResult();

    }

    public function getHistory($id){
        $qb = $this->createQueryBuilder('i');

        $qb
            ->where('i.product = :id')
            ->setParameter('id', $id)
            ->select('i.bid, i.date')
            ->leftJoin('i.User', 'user')
            ->addSelect('user.username')
            ->orderBy('i.bid','DESC');


        return  $qb->getQuery()->getResult();

    }


}

<?php

namespace App\Repository;

use App\Entity\ReponsesCreateByUsers;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<ReponsesCreateByUsers>
 *
 * @method ReponsesCreateByUsers|null find($id, $lockMode = null, $lockVersion = null)
 * @method ReponsesCreateByUsers|null findOneBy(array $criteria, array $orderBy = null)
 * @method ReponsesCreateByUsers[]    findAll()
 * @method ReponsesCreateByUsers[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ReponsesCreateByUsersRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ReponsesCreateByUsers::class);
    }

//    /**
//     * @return ReponsesCreateByUsers[] Returns an array of ReponsesCreateByUsers objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('r')
//            ->andWhere('r.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('r.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?ReponsesCreateByUsers
//    {
//        return $this->createQueryBuilder('r')
//            ->andWhere('r.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}

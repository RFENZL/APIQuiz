<?php

namespace App\Repository;

use App\Entity\Umtiti;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Umtiti>
 *
 * @method Umtiti|null find($id, $lockMode = null, $lockVersion = null)
 * @method Umtiti|null findOneBy(array $criteria, array $orderBy = null)
 * @method Umtiti[]    findAll()
 * @method Umtiti[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UmtitiRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Umtiti::class);
    }

//    /**
//     * @return Umtiti[] Returns an array of Umtiti objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('u')
//            ->andWhere('u.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('u.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Umtiti
//    {
//        return $this->createQueryBuilder('u')
//            ->andWhere('u.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}

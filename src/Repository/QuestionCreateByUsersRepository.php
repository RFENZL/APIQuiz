<?php

namespace App\Repository;

use App\Entity\QuestionCreateByUsers;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<QuestionCreateByUsers>
 *
 * @method QuestionCreateByUsers|null find($id, $lockMode = null, $lockVersion = null)
 * @method QuestionCreateByUsers|null findOneBy(array $criteria, array $orderBy = null)
 * @method QuestionCreateByUsers[]    findAll()
 * @method QuestionCreateByUsers[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class QuestionCreateByUsersRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, QuestionCreateByUsers::class);
    }

//    /**
//     * @return QuestionCreateByUsers[] Returns an array of QuestionCreateByUsers objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('q')
//            ->andWhere('q.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('q.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?QuestionCreateByUsers
//    {
//        return $this->createQueryBuilder('q')
//            ->andWhere('q.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}

<?php

namespace App\Repository;

use App\Entity\Anectode;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Anectode>
 *
 * @method Anectode|null find($id, $lockMode = null, $lockVersion = null)
 * @method Anectode|null findOneBy(array $criteria, array $orderBy = null)
 * @method Anectode[]    findAll()
 * @method Anectode[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AnectodeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Anectode::class);
    }

//    /**
//     * @return Anectode[] Returns an array of Anectode objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('a')
//            ->andWhere('a.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('a.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Anectode
//    {
//        return $this->createQueryBuilder('a')
//            ->andWhere('a.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}

<?php

namespace App\Repository;

use App\Entity\Cattle;
use DateTime;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Cattle>
 *
 * @method Cattle|null find($id, $lockMode = null, $lockVersion = null)
 * @method Cattle|null findOneBy(array $criteria, array $orderBy = null)
 * @method Cattle[]    findAll()
 * @method Cattle[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CattleRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Cattle::class);
    }

    public function save(Cattle $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Cattle $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function sumMilk(): float
    {
        $query = $this->createQueryBuilder('c')
            ->select('SUM(c.milk)')
            ->getQuery();
        
        return (float) $query->getSingleScalarResult();
    }

    public function sumPortion(): float
    {
        $query = $this->createQueryBuilder('c')
            ->select('SUM(c.week_portion)')
            ->getQuery();
        
        return (float) $query->getSingleScalarResult();
    }

    public function cattleAmount(): int
    {
        $query = $this->createQueryBuilder('c')
            ->select('COUNT(c.id)')
            ->where('c.birth <= :minAge OR c.week_portion > 500')
            ->setParameter('minAge', new DateTime('-1 year'))
            ->getQuery();

        return (int) $query->getSingleScalarResult();
    }

//    /**
//     * @return Cattle[] Returns an array of Cattle objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('c.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Cattle
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}

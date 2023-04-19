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

    public function findAllOrderByBirth() {
        $query = $this->createQueryBuilder('c')
            ->orderBy('c.birth', 'ASC')
            ->getQuery();

        return $query->getResult();
    }

    // Milk
    public function sumMilk(): float
    {
        $query = $this->createQueryBuilder('c')
            ->select('SUM(c.milk)')
            ->where('c.slaughter = 0')
            ->getQuery();
        
        return (float) $query->getSingleScalarResult();
    }

    public function averageMilk(): float
    {
        $query = $this->createQueryBuilder('c')
            ->select('AVG(c.milk)')
            ->where('c.slaughter = 0')
            ->getQuery();

        return (float) $query->getSingleScalarResult();
    }

    // Portion
    public function sumPortion(): float
    {
        $query = $this->createQueryBuilder('c')
            ->select('SUM(c.week_portion)')
            ->where('c.slaughter = 0')
            ->getQuery();
        
        return (float) $query->getSingleScalarResult();
    }

    public function averagePortion(): float
    {
        $query = $this->createQueryBuilder('c')
            ->select('AVG(c.week_portion)')
            ->where('c.slaughter = 0')
            ->getQuery();

        return (float) $query->getSingleScalarResult();
    }

    // Alimentation
    public function cattleAmount(): int
    {
        $query = $this->createQueryBuilder('c')
            ->select('COUNT(c.id)')
            ->where('c.birth >= :minAge OR c.week_portion > 500')
            ->setParameter('minAge', new DateTime('-1 year'))
            ->getQuery();

        return (int) $query->getSingleScalarResult();
    }

    public function averageAmountMilk(): float    
    {
        $query = $this->createQueryBuilder('c')
            ->select('AVG(c.milk)')
            ->where('c.birth >= :minAge OR c.week_portion > 500')
            ->setParameter('minAge', new DateTime('-1 year'))
            ->getQuery();

        return (float) $query->getSingleScalarResult();
    }

    public function averageAmountPortion(): float    
    {
        $query = $this->createQueryBuilder('c')
            ->select('AVG(c.week_portion)')
            ->where('c.birth >= :minAge OR c.week_portion > 500')
            ->setParameter('minAge', new DateTime('-1 year'))
            ->getQuery();

        return (float) $query->getSingleScalarResult();
    }

    public function sendToSlaughter(): array
    {
        $query = $this->createQueryBuilder('c')
            ->select('c.id')
            ->orderBy('c.birth', 'ASC')
            ->addSelect('
                (CASE
                    WHEN c.birth <= :minAge OR
                        c.milk < :minMilk OR
                        (c.milk < :minMilk2 AND (c.week_portion / 7) > :minPortionDay) OR
                        (c.cattle_weight / 15) > :minWeight
                    THEN 1
                    ELSE 0
                END) as conditions'
            )
            ->setParameter('minAge', new DateTime('-5 year'))
            ->setParameter('minMilk', 40)
            ->setParameter('minMilk2', 70)
            ->setParameter('minPortionDay', 50)
            ->setParameter('minWeight', 18)
            ->getQuery();

        return $query->getArrayResult();
    }

    // Slaughter
    public function countCattlesSlaughter(): int
    {
        $query = $this->createQueryBuilder('c')
            ->select('COUNT(c.id)')
            ->where('c.slaughter = 1')
            ->getQuery();
        
        return (int) $query->getSingleScalarResult();
    }

    public function findByMaxDateSlaughater()
    {
        $query = $this->createQueryBuilder('c')
            ->select('MAX(c.birth)')
            ->where('c.slaughter = 1')
            ->getQuery();
        
        return $query->getSingleScalarResult();
    }

    public function findByMinDateSlaughater()
    {
        $query = $this->createQueryBuilder('c')
            ->select('MIN(c.birth)')
            ->where('c.slaughter = 1')
            ->getQuery();
        
        return $query->getSingleScalarResult();
    }

    public function sumMilkSlaughter(): float
    {
        $query = $this->createQueryBuilder('c')
            ->select('SUM(c.milk)')
            ->where('c.slaughter = 1')
            ->getQuery();
        
        return (float) $query->getSingleScalarResult();
    }

    public function sumPortionSlaughter(): float
    {
        $query = $this->createQueryBuilder('c')
            ->select('SUM(c.week_portion)')
            ->where('c.slaughter = 1')
            ->getQuery();

        return (float) $query->getSingleScalarResult();
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

<?php

namespace App\Repository;

use App\Entity\Actu;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Actu>
 *
 * @method Actu|null find($id, $lockMode = null, $lockVersion = null)
 * @method Actu|null findOneBy(array $criteria, array $orderBy = null)
 * @method Actu[]    findAll()
 * @method Actu[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ActuRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Actu::class);
    }

    public function findByType($value): array
    {
/*         return $this->createQueryBuilder('a')
            ->leftJoin('a.type','t')
            ->andWhere('t.nom = :val')
            ->setParameter('val', $value)
            ->orderBy('a.id', 'ASC')
            ->getQuery()            
            ->getResult()
        ; */
        return $this->getEntityManager()->createQuery('SELECT a From App\entity\Actu a JOIN a.type t WHERE t.nom = :val ORDER BY a.id ASC')
        ->setParameter(':val',$value)->getResult();
    }

   public function findOneByType($value): ?Actu
  {
/*        return $this->createQueryBuilder('a')
            ->leftJoin('a.type','t')
            ->andWhere('t.nom = :val')
            ->setParameter('val', $value)
            ->orderBy('a.id', 'ASC')
            ->setMaxResults(1)
            ->getQuery()
            ->getOneOrNullResult()
        ; */
        return $this->getEntityManager()->createQuery('SELECT a FROM App\entity\Actu a JOIN a.type t WHERE t.nom = :val ORDER BY a.id ASC')
        ->setParameter(':val',$value)->setMaxResults(1)->getOneOrNullResult();
    }

//    /**
//     * @return Actu[] Returns an array of Actu objects
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

//    public function findOneBySomeField($value): ?Actu
//    {
//        return $this->createQueryBuilder('a')
//            ->andWhere('a.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}

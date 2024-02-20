<?php

namespace App\Repository;

use App\Entity\Produit;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Produit>
 *
 * @method Produit|null find($id, $lockMode = null, $lockVersion = null)
 * @method Produit|null findOneBy(array $criteria, array $orderBy = null)
 * @method Produit[]    findAll()
 * @method Produit[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProduitRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Produit::class);
    }

    public function findByScat($cat,$scat)
    {
        $query = $this->createQueryBuilder('p');
        $query->leftJoin('p.sousCategory','sc')
            ->leftJoin('sc.category','c')
            ->andWhere('sc.nom = :nom')
            ->andWhere('c.nom = :val')
            ->setParameter(':val', $cat)
            ->setParameter(':nom', $scat)
            ->orderBy('p.nom', 'ASC');
            return $query->getQuery()->getResult();   
    } 

    public function findByCat($nom)
    { 
/*         $query = $this->createQueryBuilder('p');
        $query->leftJoin('p.sousCategory','sc')
        ->leftJoin('sc.category','c')
        ->andWhere('c.nom = :nom')
        ->setParameter(':nom', $nom)
        ->orderBy('p.nom', 'ASC');
        return $query->getQuery()->getResult();  */
        return $this->getEntityManager()
        ->createQuery('SELECT p From App\entity\Produit p JOIN p.sousCategory sc JOIN sc.category c WHERE c.nom= :nom')
        ->setParameter(':nom',$nom)->getResult();
    }

    public function search($mot)
    { 
        return $this->getEntityManager()
        ->createQuery(
            'SELECT p From App\entity\Produit p JOIN p.sousCategory sc JOIN sc.category c
                WHERE p.nom LIKE :mot 
                OR p.description LIKE :mot 
                OR sc.nom LIKE :mot
                OR c.nom LIKE :mot'
        )
        ->setParameter(':mot','%'.$mot.'%')->getResult();
    }
//    /**
//     * @return Produit[] Returns an array of Produit objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('p.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Produit
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}

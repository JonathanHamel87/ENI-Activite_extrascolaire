<?php

namespace App\Repository;

use App\Entity\Sortie;
use ContainerV8Cvg8w\getDebug_DumpListenerService;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Sortie|null find($id, $lockMode = null, $lockVersion = null)
 * @method Sortie|null findOneBy(array $criteria, array $orderBy = null)
 * @method Sortie[]    findAll()
 * @method Sortie[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SortieRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Sortie::class);
    }

    public function findByFilter($search, $campusId, $dateDebut, $dateFin, $organisateur, $inscrit, $nonInscrit, $sortieFini, $userId){
        if ($organisateur == true){
            if ($dateDebut == "" && $dateFin == ""){
                return $this->createQueryBuilder('s')
                    ->andWhere('s.nom LIKE :search')
                    ->setParameter('search', $search.'%')
                    ->andWhere('s.campus = :campusId')
                    ->setParameter('campusId', $campusId)
                    ->andWhere('s.organisateur = :userId')
                    ->setParameter('userId', $userId)
                    ->orderBy('s.id', 'ASC')
                    ->setMaxResults(10)
                    ->getQuery()
                    ->getResult()
                    ;
            }else{
                return $this->createQueryBuilder('s')
                    ->andWhere('s.nom LIKE :search')
                    ->setParameter('search', $search.'%')
                    ->andWhere('s.campus = :campusId')
                    ->setParameter('campusId', $campusId)
                    ->andWhere('s.dateHeureDebut >= :dateDebut')
                    ->andWhere('s.organisateur = :userId')
                    ->setParameter('userId', $userId)
                    ->setParameter('dateDebut', $dateDebut)
                    ->andWhere('s.dateHeureDebut <= :dateFin')
                    ->setParameter('dateFin', $dateFin)
                    ->orderBy('s.id', 'ASC')
                    ->setMaxResults(10)
                    ->getQuery()
                    ->getResult()
                    ;
            }
        }
        /*->addSelect('b')
            ->leftJoin('OCPlatformBundle:BannedIp','b','WITH','b.ip = u.ip')*/
        if ($inscrit == true){
            if ($dateDebut == "" && $dateFin == ""){
                return $this->createQueryBuilder('s')
                    ->innerJoin('s.participants', 'p')
                    ->where('p.id = :userId')
                    ->setParameter('userId', $userId)
                    ->andWhere('s.nom LIKE :search')
                    ->setParameter('search', $search.'%')
                    ->andWhere('s.campus = :campusId')
                    ->setParameter('campusId', $campusId)
                    ->orderBy('s.id', 'ASC')
                    ->setMaxResults(10)
                    ->getQuery()
                    ->getResult()
                    ;
            }else{
                return $this->createQueryBuilder('s')
                    ->innerJoin('s.participants', 'p')
                    ->where('p.id = :userId')
                    ->setParameter('userId', $userId)
                    ->andWhere('s.nom LIKE :search')
                    ->setParameter('search', $search.'%')
                    ->andWhere('s.campus = :campusId')
                    ->setParameter('campusId', $campusId)
                    ->andWhere('s.dateHeureDebut >= :dateDebut')
                    ->setParameter('dateDebut', $dateDebut)
                    ->andWhere('s.dateHeureDebut <= :dateFin')
                    ->setParameter('dateFin', $dateFin)
                    ->orderBy('s.id', 'ASC')
                    ->setMaxResults(10)
                    ->getQuery()
                    ->getResult()
                    ;
            }
        }
        if ($nonInscrit == true){
            if ($dateDebut == "" && $dateFin == ""){
                return $this->createQueryBuilder('s')
                    ->innerJoin('s.participants', 'p')
                    ->where('p.id != :userId')
                    ->setParameter('userId', $userId)
                    ->andWhere('s.nom LIKE :search')
                    ->setParameter('search', $search.'%')
                    ->andWhere('s.campus = :campusId')
                    ->setParameter('campusId', $campusId)
                    ->orderBy('s.id', 'ASC')
                    ->setMaxResults(10)
                    ->getQuery()
                    ->getResult()
                    ;
            }else{
                return $this->createQueryBuilder('s')
                    ->innerJoin('s.participants', 'p')
                    ->where('p.id != :userId')
                    ->setParameter('userId', $userId)
                    ->andWhere('s.nom LIKE :search')
                    ->setParameter('search', $search.'%')
                    ->andWhere('s.campus = :campusId')
                    ->setParameter('campusId', $campusId)
                    ->andWhere('s.dateHeureDebut >= :dateDebut')
                    ->setParameter('dateDebut', $dateDebut)
                    ->andWhere('s.dateHeureDebut <= :dateFin')
                    ->setParameter('dateFin', $dateFin)
                    ->orderBy('s.id', 'ASC')
                    ->setMaxResults(10)
                    ->getQuery()
                    ->getResult()
                    ;
            }
        }
        if ($sortieFini == true){
            if ($dateDebut == "" && $dateFin == ""){
                return $this->createQueryBuilder('s')
                    ->andWhere('s.nom LIKE :search')
                    ->setParameter('search', $search.'%')
                    ->andWhere('s.campus = :campusId')
                    ->setParameter('campusId', $campusId)
                    ->andWhere('s.etat = 5')
                    ->orderBy('s.id', 'ASC')
                    ->setMaxResults(10)
                    ->getQuery()
                    ->getResult()
                    ;
            }else{
                return $this->createQueryBuilder('s')
                    ->andWhere('s.nom LIKE :search')
                    ->setParameter('search', $search.'%')
                    ->andWhere('s.campus = :campusId')
                    ->setParameter('campusId', $campusId)
                    ->andWhere('s.dateHeureDebut >= :dateDebut')
                    ->setParameter('dateDebut', $dateDebut)
                    ->andWhere('s.dateHeureDebut <= :dateFin')
                    ->setParameter('dateFin', $dateFin)
                    ->andWhere('s.etat = 5')
                    ->orderBy('s.id', 'ASC')
                    ->setMaxResults(10)
                    ->getQuery()
                    ->getResult()
                    ;
            }
        }
        if (!$organisateur AND !$inscrit AND !$nonInscrit AND !$sortieFini){
            if ($dateDebut == "" && $dateFin == ""){
                return $this->createQueryBuilder('s')
                    ->andWhere('s.nom LIKE :search')
                    ->setParameter('search', $search.'%')
                    ->andWhere('s.campus = :campusId')
                    ->setParameter('campusId', $campusId)
                    ->orderBy('s.id', 'ASC')
                    ->setMaxResults(10)
                    ->getQuery()
                    ->getResult()
                    ;
            }else{
                return $this->createQueryBuilder('s')
                    ->andWhere('s.nom LIKE :search')
                    ->setParameter('search', $search.'%')
                    ->andWhere('s.campus = :campusId')
                    ->setParameter('campusId', $campusId)
                    ->andWhere('s.dateHeureDebut >= :dateDebut')
                    ->setParameter('dateDebut', $dateDebut)
                    ->andWhere('s.dateHeureDebut <= :dateFin')
                    ->setParameter('dateFin', $dateFin)
                    ->orderBy('s.id', 'ASC')
                    ->setMaxResults(10)
                    ->getQuery()
                    ->getResult()
                    ;
            }
        }
    }

    // /**
    //  * @return Sortie[] Returns an array of Sortie objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('s.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Sortie
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}

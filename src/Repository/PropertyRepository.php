<?php

namespace App\Repository;

use App\Entity\Property;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\DBAL\Query\QueryBuilder;
use Doctrine\ORM\QueryBuilder as ORMQueryBuilder;
use Doctrine\Persistence\ManagerRegistry;

// Le Repository permet de créer des requêtes SQL

/**
 * @method Property|null find($id, $lockMode = null, $lockVersion = null)
 * @method Property|null findOneBy(array $criteria, array $orderBy = null)
 * @method Property[]    findAll()
 * @method Property[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PropertyRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Property::class);
    }

    /**
     * @return Property[]
     */
    public function findAllVisible(): array
    {
        // return $this->createQueryBuilder('p')
        //     ->where('p.sold = false')
        return $this->findVisibleQuery()
            ->getQuery()
            ->getResult();
    }

    /**
     * @return Property[]
     */
    public function findLatest(): array
    {
        // return $this->createQueryBuilder('p')
        //     ->where('p.sold = false')
        return $this->findVisibleQuery()
            ->setMaxResults(4)
            ->getQuery()
            ->getResult();
    }

    # on place les méthodes privées à la fin car on ne les regarde jamais
    # répétition présente dans findAllVisible et findLatest
    # création d'une méthode privée permettant de générer la requête pour trouver tous les enregistrements qui sont visibles
    private function findVisibleQuery(): ORMQueryBuilder
    {
        return $this->createQueryBuilder('p')
            ->where('p.sold = false');
    }



    // /**
    //  * @return Property[] Returns an array of Property objects
    //  */
    /*
    public function findByExampleField($value)
    {
        // # queryBuilder -> objet permettant de concevoir une requête -> on lui donne un alias (ici 'p' correspondra à Property par exemple)
        // return $this->createQueryBuilder('p')
        //     # définir des conditions 
        //     ->andWhere('p.exampleField = :val')
        //     # ajouter des params
        //     ->setParameter('val', $value)
        //     # définir l'ordre
        //     ->orderBy('p.id', 'ASC')
        //     # mettre une limite de résultats, etc ..
        //     ->setMaxResults(10)
        //     # une fois que l'on est satisfait, on fait un getQuery() pour récupérer la requête
        //     ->getQuery()
        //     # et un getResult() pour récupérer les résultats
        //     ->getResult();
    }
    */

    /*
    public function findOneBySomeField($value): ?Property
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}

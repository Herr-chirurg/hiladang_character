<?php

namespace App\Repository;

use App\Entity\Character;
use App\Entity\Scenario;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Character>
 */
class CharacterRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Character::class);
    }

    /**
     * @return Character[] Returns an array of Character objects NOT linked to the given Scenario
     */
    public function findCharactersNotInScenario(Scenario $scenario): array
    {
        $entityManager = $this->getEntityManager();

        // Crée une sous-requête qui sélectionne les IDs des Characters liés au Scénario
        $subQuery = $this->createQueryBuilder('c2')
            ->select('c2.id')
            ->innerJoin('c2.scenarios', 's')
            ->where('s.id = :scenarioId');

        // Requête principale : Sélectionne les Characters dont l'ID n'est pas dans les résultats de la sous-requête
        $query = $this->createQueryBuilder('c')
            ->where($this->getEntityManager()->getExpressionBuilder()->notIn('c.id', $subQuery->getDQL()))
            ->setParameter('scenarioId', $scenario->getId())
            ->getQuery();

        return $query->getResult();
    }

    //    /**
    //     * @return Character[] Returns an array of Character objects
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

    //    public function findOneBySomeField($value): ?Character
    //    {
    //        return $this->createQueryBuilder('c')
    //            ->andWhere('c.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}

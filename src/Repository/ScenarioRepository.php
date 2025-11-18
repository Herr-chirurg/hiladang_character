<?php

namespace App\Repository;

use App\Entity\Scenario;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Scenario>
 */
class ScenarioRepository extends ServiceEntityRepository
{
    private $characterRepository;

    public function __construct(ManagerRegistry $registry, CharacterRepository $characterRepository)
    {
        $this->characterRepository = $characterRepository; 
        parent::__construct($registry, Scenario::class);
    }

    public function findCharactersNotInScenario(Scenario $scenario) {

        $subQuery = $this->createQueryBuilder('scenario');

        $subQuery
            ->innerJoin('scenario.tokens', 'token')
            ->innerJoin('token.character', 'character')
            ->where('scenario.id = :scenarioId')
            ->select('character');

        // Requête principale : Sélectionne les Characters dont l'ID n'est pas dans les résultats de la sous-requête
        $query = $this->characterRepository->createQueryBuilder('c')
            ->where($this->getEntityManager()->getExpressionBuilder()->notIn('c.id', $subQuery->getDQL()))
            ->setParameter('scenarioId', $scenario->getId())
            ->getQuery();

        return $query->getResult();

    }
}

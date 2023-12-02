<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\LogRequest;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\QueryBuilder;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<LogRequest>
 *
 * @method LogRequest|null find($id, $lockMode = null, $lockVersion = null)
 * @method LogRequest|null findOneBy(array $criteria, array $orderBy = null)
 * @method LogRequest[] findAll()
 * @method LogRequest[] findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class LogRequestRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, LogRequest::class);
    }

    public function findByClassNameAndOperation(?string $className, ?string $operation): ?LogRequest
    {
        return $this->findByClassNameAndOperationQueryBuilder($className, $operation)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }

    public function requestCountByClassNameAndOperation(?string $className, ?string $operation): int
    {
        $result = $this->findByClassNameAndOperationQueryBuilder($className, $operation)
            ->select('lr.requestCount')
            ->getQuery()
            ->getOneOrNullResult()
        ;

        return $result['requestCount'] ?? 0;
    }

    private function findByClassNameAndOperationQueryBuilder(?string $className, ?string $operation): QueryBuilder
    {
        return $this->createQueryBuilder('lr')
            ->where('lr.className = :className')
            ->andWhere('lr.operation = :operation')
            ->setParameter('className', $className)
            ->setParameter('operation', $operation)
        ;
    }
}

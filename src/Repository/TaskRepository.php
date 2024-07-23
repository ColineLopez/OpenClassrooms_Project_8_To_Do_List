<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\Task;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Task>
 */
class TaskRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Task::class);
    }

    public function findActiveTasks(\DateTime $now): array
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.deadline IS NULL OR t.deadline >= :now')
            ->setParameter('now', $now)
            ->getQuery()
            ->getResult();
    }

    public function findExpiredTasks(\DateTime $now): array
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.deadline < :now')
            ->setParameter('now', $now)
            ->getQuery()
            ->getResult();
    }
}

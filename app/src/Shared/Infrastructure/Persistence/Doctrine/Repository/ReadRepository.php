<?php

declare(strict_types=1);

namespace App\Shared\Infrastructure\Persistence\Doctrine\Repository;

use App\Shared\Domain\Repository\ReadInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

/**
 * @template T of object
 *
 * @extends ServiceEntityRepository<T>
 */
abstract class ReadRepository extends ServiceEntityRepository implements ReadInterface
{
    protected bool $readOnly = false;

    public function findById(string $id): ?object
    {
        return $this->find($id);
    }

    /**
     * @return array<T>
     */
    public function findAll(): array
    {
        return parent::findAll();
    }
}

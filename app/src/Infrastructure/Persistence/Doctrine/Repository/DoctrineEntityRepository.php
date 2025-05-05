<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence\Doctrine\Repository;

use App\Domain\Entity\Entity;
use App\Domain\Exceptions\EntityNotFoundException;
use App\Domain\Repository\EntityWriteRepositoryInterface;
use App\Shared\Infrastructure\Persistence\Doctrine\Repository\WriteRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends WriteRepository<Entity>
 */
class DoctrineEntityRepository extends WriteRepository implements EntityWriteRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Entity::class);
    }

    public function findOne(int $id): ?Entity
    {
        return $this->find($id);
    }

    /**
     * @throws EntityNotFoundException
     */
    public function getOne(int $id): Entity
    {
        if (!$entity = $this->findOne($id)) {
            throw EntityNotFoundException::byId($id);
        }

        return $entity;
    }

    public function findOneByName(string $name): ?Entity
    {
        return $this->findOneBy(['name' => $name]);
    }

    /**
     * @throws EntityNotFoundException
     */
    public function getOneByName(string $name): Entity
    {
        if (!$entity = $this->findOneByName($name)) {
            throw EntityNotFoundException::byName($name);
        }

        return $entity;
    }

    public function persist(Entity $entity, bool $flushAll = true): void
    {
        parent::save($entity, flushAll: $flushAll);
    }

    public function remove(Entity $entity, bool $flushAll = true): void
    {
        parent::delete($entity, flushAll: $flushAll);
    }
}

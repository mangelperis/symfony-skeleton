<?php

declare(strict_types=1);

namespace App\Shared\Infrastructure\Persistence\Doctrine\Repository;

use App\Shared\Domain\Repository\WriteInterface;

/**
 * @template T of object
 *
 * @extends ReadRepository<T>
 */
class WriteRepository extends ReadRepository implements WriteInterface
{
    public function clear(): void
    {
        $this->getEntityManager()->clear();
    }

    public function save(object $object, bool $flushAll = true): void
    {
        $this->checkReadOnly();

        $this->getEntityManager()->persist($object);
        if ($flushAll) {
            $this->getEntityManager()->flush();
        }
    }

    public function delete(object $object, bool $flushAll = true): void
    {
        $this->checkReadOnly();

        $this->getEntityManager()->remove($object);
        if ($flushAll) {
            $this->getEntityManager()->flush();
        }
    }

    public function flush(): void
    {
        $this->checkReadOnly();
        $this->getEntityManager()->flush();
    }

    /**
     * @param T ...$collection
     */
    public function saveCollection(object ...$collection): void
    {
        $this->checkReadOnly();

        foreach ($collection as $object) {
            $this->getEntityManager()->persist($object);
        }

        $this->getEntityManager()->flush();
    }

    /**
     * @param T ...$collection
     */
    public function removeCollection(object ...$collection): void
    {
        $this->checkReadOnly();

        foreach ($collection as $object) {
            $this->getEntityManager()->remove($object);
        }

        $this->getEntityManager()->flush();
    }

    protected function checkReadOnly(): void
    {
        if ($this->readOnly) {
            throw new \RuntimeException('Repository is read-only');
        }
    }
}

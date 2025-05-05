<?php

namespace App\Domain\Repository;

use App\Domain\Entity\Entity;

interface EntityWriteRepositoryInterface extends EntityReadRepositoryInterface
{
    public function persist(Entity $entity): void;

    public function remove(Entity $entity): void;
}

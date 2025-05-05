<?php

namespace App\Domain\Repository;

use App\Domain\Entity\Entity;

interface EntityReadRepositoryInterface
{
    public function findOne(int $id): ?Entity;

    public function getOne(int $id): Entity;

    public function findOneByName(string $name): ?Entity;

    public function getOneByName(string $name): Entity;
}

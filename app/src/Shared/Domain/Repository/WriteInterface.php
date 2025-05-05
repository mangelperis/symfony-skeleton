<?php

namespace App\Shared\Domain\Repository;

interface WriteInterface
{
    public function save(object $object): void;

    public function delete(object $object): void;
}

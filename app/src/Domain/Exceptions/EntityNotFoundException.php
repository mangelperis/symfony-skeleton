<?php

declare(strict_types=1);

namespace App\Domain\Exceptions;

use App\Shared\Domain\Exception\Concept;
use App\Shared\Domain\Exception\CoreException;
use App\Shared\Domain\Exception\NotFoundException;

class EntityNotFoundException extends NotFoundException
{
    public const string CODE_STRING = 'ENTITY_NOT_FOUND';

    public static function byId(int $id): self
    {
        $exception = new self(\sprintf('Entity with id %s not found', $id));
        $exception->addConcept(new Concept(CoreException::ENTITY, $id));

        return $exception;
    }

    public static function byName(string $name): self
    {
        $exception = new self(\sprintf('Entity with name: %s not found', $name));
        $exception->addConcept(new Concept(CoreException::ENTITY, $name));

        return $exception;
    }
}

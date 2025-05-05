<?php

declare(strict_types=1);

namespace App\Shared\Domain\Exception;

class Concept
{
    private string $concept;

    private int|string|null $id;

    public function __construct(string $concept, int|string|null $id)
    {
        $this->concept = $concept;
        $this->id = $id;
    }

    public function concept(): string
    {
        return $this->concept;
    }

    public function id(): ?int
    {
        return $this->id;
    }
}

<?php

declare(strict_types=1);

namespace App\Shared\Domain\Exception;

class ConceptCollection
{
    /** @var Concept[] */
    private array $concepts = [];

    public function addValue(Concept $concept): self
    {
        $this->concepts[] = $concept;

        return $this;
    }

    /**
     * @return Concept[]
     */
    public function concepts(): array
    {
        return $this->concepts;
    }
}

<?php

declare(strict_types=1);

namespace App\Shared\Domain\Exception;

abstract class CoreException extends \Exception
{
    public const CODE_STRING = '';

    /**
     * ADD any other all constants here.
     */
    protected const ENTITY = 'ENTITY';

    protected ConceptCollection $conceptCollection;

    public function __construct(string $message = '', int $code = 0, ?\Throwable $previous = null)
    {
        $this->conceptCollection = new ConceptCollection();
        parent::__construct($message, $code, $previous);
    }

    public function addConcept(Concept $concept): self
    {
        $this->conceptCollection()->addValue($concept);

        return $this;
    }

    public function concepts(): string
    {
        $concepts = [];
        foreach ($this->conceptCollection()->concepts() as $concept) {
            $concepts[] = $concept->concept();
        }

        return implode(', ', $concepts);
    }

    public function ids(): string
    {
        $ids = [];
        foreach ($this->conceptCollection()->concepts() as $concept) {
            $ids[] = $concept->id() ?? 'null';
        }

        return implode(', ', $ids);
    }

    public function conceptCollection(): ConceptCollection
    {
        return $this->conceptCollection;
    }
}

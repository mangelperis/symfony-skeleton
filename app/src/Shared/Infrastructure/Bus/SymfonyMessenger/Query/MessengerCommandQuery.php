<?php

declare(strict_types=1);

namespace App\Shared\Infrastructure\Bus\SymfonyMessenger\Query;

use App\Shared\Application\Bus\Query\Query;
use Symfony\Component\Messenger\Stamp\HandledStamp;

class MessengerCommandQuery implements QueryBus
{
    public function __construct(private MessageBusInterface $bus)
    {
    }

    public function ask(Query $query): mixed
    {
        $envelope = $this->bus->dispatch($query);
        /** @var HandledStamp $handled */
        $handled = $envelope->last(HandledStamp::class);

        return $handled->getResult();
    }
}

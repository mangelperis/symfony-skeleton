<?php

declare(strict_types=1);

namespace App\Shared\Infrastructure\Bus\SymfonyMessenger\Command;

use App\Shared\Application\Bus\Command\Command;
use App\Shared\Application\Bus\Command\CommandBus;
use Symfony\Component\Messenger\MessageBusInterface;

class MessengerCommandBus implements CommandBus
{
    public function __construct(private MessageBusInterface $bus)
    {
    }

    public function dispatch(Command $command): void
    {
        $this->bus->dispatch($command);
    }
}

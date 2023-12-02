<?php

declare(strict_types=1);

namespace App\Event;

use Symfony\Contracts\EventDispatcher\Event;

class LogRequestEvent extends Event
{
    public const LOG = 'request.log';

    public function __construct(
        public ?string $className,
        public ?string $operation,
    ) {}
}

<?php

declare(strict_types=1);

namespace App\Factory;

use App\Entity\LogRequest;

class LogRequestFactory
{
    public function createNew(): LogRequest
    {
        return new LogRequest();
    }

    public function createWithData(
        ?string $className,
        ?string $operation,
    ): LogRequest {
        $logRequest = $this->createNew();

        $logRequest->setClassName($className);
        $logRequest->setOperation($operation);

        return $logRequest;
    }
}

<?php

declare(strict_types=1);

namespace App\Controller\Api;

use App\Provider\CustomerListProvider;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Attribute\AsController;

#[AsController]
class FetchCustomersController
{
    public function __construct(
        private CustomerListProvider $customerListProvider,
    ) {}

    public function __invoke(): JsonResponse
    {
        return new JsonResponse($this->customerListProvider->provide());
    }
}

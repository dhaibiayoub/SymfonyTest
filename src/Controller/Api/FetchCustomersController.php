<?php

declare(strict_types=1);

namespace App\Controller\Api;

use App\Entity\Customer;
use App\Repository\CustomerRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpKernel\Attribute\AsController;

#[AsController]
class FetchCustomersController extends AbstractController
{
    public function __construct(
        private CustomerRepository $customerRepository
    ) {}

    /**
     * @return Customer[] Returns an array of Customer objects
     */
    public function __invoke(): array
    {
        return $this->customerRepository->findAll();
    }
}

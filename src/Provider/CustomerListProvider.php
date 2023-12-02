<?php

declare(strict_types=1);

namespace App\Provider;

use App\Entity\Customer;
use App\Event\LogRequestEvent;
use App\Repository\CustomerRepository;
use App\Repository\LogRequestRepository;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Symfony\Contracts\EventDispatcher\EventDispatcherInterface;

class CustomerListProvider
{
    private const OPERATION_LIST = 'list';

    public function __construct(
        private CustomerRepository $customerRepository,
        private NormalizerInterface $normalizer,
        private EventDispatcherInterface $dispatcher,
        private LogRequestRepository $logRequestRepository,
    ) {}

    /**
     * @return array<mixed>
     */
    public function provide(): array
    {
        $this->dispatcher->dispatch(new LogRequestEvent(Customer::class, self::OPERATION_LIST), LogRequestEvent::LOG);

        return [
            'customers' => $this->normalizer->normalize($this->customerRepository->findAll(), null, ['groups' => ['customer:list']]),
            'requestCount' => $this->logRequestRepository->requestCountByClassNameAndOperation(Customer::class, self::OPERATION_LIST),
        ];
    }
}

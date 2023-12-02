<?php

declare(strict_types=1);

namespace App\EventSubscriber;

use App\Event\LogRequestEvent;
use App\Factory\LogRequestFactory;
use App\Repository\LogRequestRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class LogRequestSubscriber implements EventSubscriberInterface
{
    public function __construct(
        private LogRequestRepository $logRequestRepository,
        private EntityManagerInterface $entityManager,
        private LogRequestFactory $logRequestFactory,
    ) {}

    public static function getSubscribedEvents(): array
    {
        return [
            LogRequestEvent::LOG => 'logRequest',
        ];
    }

    public function logRequest(LogRequestEvent $event): void
    {
        $logRequest = $this->logRequestRepository->findByClassNameAndOperation($event->className, $event->operation);
        if (null === $logRequest) {
            $logRequest = $this->logRequestFactory->createWithData($event->className, $event->operation);
            $this->entityManager->persist($logRequest);
        }

        $logRequest->setRequestCount($logRequest->getRequestCount() + 1);

        $this->entityManager->flush();
    }
}

<?php

namespace App\EventSubscriber;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\ResponseEvent;

class ResponseSubscriber implements EventSubscriberInterface
{
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    private $methods = ['POST', 'PUT', 'PATCH', 'DELETE'];

    private $allowedCodes = [200, 201, 204];

    public function __construct(
        EntityManagerInterface $entityManager
    ) {
        $this->entityManager = $entityManager;
    }

    public function onKernelResponse(ResponseEvent $event): void
    {
        $response = $event->getResponse();
        $conn = $this->entityManager->getConnection();
        $responseCode = $response->getStatusCode();
        $method = $event->getRequest()->getMethod();
        if (in_array($method, $this->methods)) {
            if (!in_array($responseCode, $this->allowedCodes)) {
                $conn->rollback();

                return;
            }
            $conn->commit();
        }
        echo ' ';
    }

    public static function getSubscribedEvents()
    {
        return [
            'kernel.response' => 'onKernelResponse',
        ];
    }
}

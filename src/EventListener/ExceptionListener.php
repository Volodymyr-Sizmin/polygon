<?php

declare(strict_types=1);

namespace App\EventListener;

use DomainException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class ExceptionListener
{
    public function onKernelException(ExceptionEvent $event): void
    {
        $exception = $event->getThrowable();
        $request = $event->getRequest();

        if ($exception instanceof NotFoundHttpException) {
            $event->setResponse(
                new JsonResponse(
                    [
                        'success' => false,
                        'body' => [
                            'exception' => get_class($exception),
                            'message' => $exception->getMessage(),
                        ],
                    ],
                    $exception->getStatusCode()
                )
            );
        }

        // Only json exceptions are caught here
        if ('json' !== $request->getContentType()) {
            return;
        }
        if ($exception instanceof DomainException) {
            $event->setResponse(
                new JsonResponse(
                    [
                        'success' => false,
                        'body' => [
                            'message' => $exception->getMessage(),
                            'code' => $exception->getCode(),
                        ],
                    ],
                    $exception->getCode()
                )
            );
        }
    }
}

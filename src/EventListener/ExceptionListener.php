<?php

namespace App\EventListener;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class ExceptionListener
{
    public function onKernelException(ExceptionEvent $event): void
    {
        $exception = $event->getThrowable();

        if ($exception instanceof NotFoundHttpException) {
            $event->setResponse(
                new JsonResponse(
                    [
                        'success' => false,
                        'body' => [
                            'exception' => get_class($exception),
                            'message' => $exception->getMessage(),
                        ]
                    ], 
                    $exception->getStatusCode()
                )
            );
        }
    }
}
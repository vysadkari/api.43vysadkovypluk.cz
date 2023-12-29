<?php

namespace App\EventListener;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class HttpExceptionListener
{
    public function onKernelException(ExceptionEvent $event)
    {
        $exception = $event->getThrowable();

        if ($exception instanceof BadRequestHttpException) {
            $response = new JsonResponse([
                'message' => $exception->getMessage()
            ], 400);

            $event->setResponse($response);
        }
    }
}

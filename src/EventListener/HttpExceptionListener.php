<?php

namespace App\EventListener;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class HttpExceptionListener
{
    private const DEFAULT_HEADERS = ['Access-Control-Allow-Origin' => '*'];

    public function onKernelException(ExceptionEvent $event)
    {
        $exception = $event->getThrowable();

        if ($exception instanceof BadRequestHttpException) {
            $response = new JsonResponse([
                'message' => $exception->getMessage()
            ], 400, self::DEFAULT_HEADERS);

            $event->setResponse($response);
        }
    }
}

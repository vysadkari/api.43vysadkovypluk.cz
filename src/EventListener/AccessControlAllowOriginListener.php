<?php

namespace App\EventListener;

use Symfony\Component\HttpKernel\Event\ResponseEvent;
use Symfony\Component\EventDispatcher\Attribute\AsEventListener;

#[AsEventListener(event: ResponseEvent::class, method: 'setHeaders')]
class AccessControlAllowOriginListener
{
    private array $allowedOrigins;

    public function __construct(array $allowedOrigins)
    {
        $this->allowedOrigins = $allowedOrigins;
    }

    public function setHeaders(ResponseEvent $event)
    {
        $response = $event->getResponse();
        $referer = $_SERVER['HTTP_REFERER'] ?? '';
        $callingDomain = parse_url($referer, PHP_URL_SCHEME) . '://' . parse_url($referer, PHP_URL_HOST);

        $port = parse_url($referer, PHP_URL_PORT);
        if ($port) {
            $callingDomain .= ':' . $port;
        }

        if (in_array($callingDomain, $this->allowedOrigins)) {
            $response->headers->set('Access-Control-Allow-Origin', $callingDomain);
        }
    }
}

<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class BaseController extends AbstractController
{
    protected function sendJson(mixed $json, int $statusCode = 200): Response
    {
        return $this->json($json, $statusCode);
    }

    protected function loadData(string $filename, bool $splitLines = false): array|string
    {
        $fileContent =  file_get_contents(__DIR__ . '/../../data/' . $filename);

        if ($splitLines) {
            return explode("\n", trim($fileContent));
        } else {
            return $fileContent;
        }
    }
}

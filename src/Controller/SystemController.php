<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\KernelInterface;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Output\NullOutput;
use Symfony\Component\Routing\Annotation\Route;

class SystemController extends BaseController
{
    private $endpointToken;

    public function __construct(string $endpointToken)
    {
        $this->endpointToken = $endpointToken;
    }

    #[Route('/system/clear-cache', name: 'system', methods: ['GET'])]
    public function clearCache(Request $request, KernelInterface $kernel): Response
    {
        $authorizationHeader = $request->headers->get('Authorization');
        $requestToken = substr($authorizationHeader, 7);

        if ($authorizationHeader === null || substr($authorizationHeader, 0, 7) !== 'Bearer ' || $requestToken !== $this->endpointToken) {
            return $this->json(['message' => 'Cache is what it is'], 401);
        }

        $application = new Application($kernel);
        $application->setAutoExit(false);

        $input = new ArrayInput([
            'command' => 'cache:clear',
        ]);

        $output = new NullOutput();
        $application->run($input, $output);

        return $this->json([
            'message' => 'Cache is trash',
        ]);
    }
}

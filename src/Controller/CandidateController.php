<?php

namespace App\Controller;

use App\Entity\CandidateLegacy;
use App\Entity\CandidateChatLegacy;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Uid\Uuid;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class CandidateController extends BaseController
{
    private const DEFAULT_CANDYDATE_TYPE = 'vzp';

    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    #[Route('/candidate', name: 'candidate', methods: ['POST'])]
    public function newCandidate(Request $request, ValidatorInterface $validator): Response
    {
        $name = $request->request->get('name');
        $phoneNumber = $request->request->get('phoneNumber');
        $email = $request->request->get('email');
        $message = $request->request->get('message');

        $uuid = Uuid::v4();

        $candidate = new CandidateLegacy();
        $candidate->setName($name);
        $candidate->setTel($phoneNumber);
        $candidate->setEmail($email);
        $candidate->setInitToken($uuid);
        $candidate->setType(self::DEFAULT_CANDYDATE_TYPE);

        $errors = $validator->validate($candidate);

        if (count($errors) > 0) {
            throw new BadRequestHttpException($errors[0]->getMessage());
        }

        $this->entityManager->persist($candidate);
        $this->entityManager->flush();

        $candidateChat = new CandidateChatLegacy();
        $candidateChat->setMessage($message);
        $candidateChat->setSender($name);
        $candidateChat->setCandidateId($candidate->getId());

        $this->entityManager->persist($candidateChat);
        $this->entityManager->flush();

        return $this->sendJson([
            "token" => $uuid,
        ]);
    }
}

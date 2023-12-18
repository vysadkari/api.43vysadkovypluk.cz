<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ContactController extends BaseController
{
    private const ADDRESS_FILENAME = 'adresa.txt';
    private const PHONE_FILENAME = 'telefon.txt';
    private const EMAIL_FILENAME = 'email.txt';

    #[Route('/contact', name: 'contact')]
    public function contactInformation(): Response
    {
        $rawAddress = $this->loadData(self::ADDRESS_FILENAME, true);
        $rawPhone = $this->loadData(self::PHONE_FILENAME, true);
        $rawEmail = $this->loadData(self::EMAIL_FILENAME, true);

        $phones = [];
        foreach ($rawPhone as $phone) {
            $phone = explode('-', $phone);

            $phones[] = [
                "phoneNumber" => trim($phone[0]),
                "title" => trim($phone[1]),
            ];
        }

        $emails = [];
        foreach ($rawEmail as $email) {
            $emails[] = trim($email);
        }

        $contactInformation = [
            "address" => [
                "address" => $rawAddress[0],
                "mapLink" => $rawAddress[1],
            ],
            "phone" => $phones,
            "email" => $emails,
        ];

        return $this->sendJson($contactInformation);
    }
}

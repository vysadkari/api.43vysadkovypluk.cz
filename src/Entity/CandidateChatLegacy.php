<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: "uchazec_chat")]
class CandidateChatLegacy
{
    #[ORM\Id, ORM\GeneratedValue, ORM\Column(type: "integer")]
    private int $id;

    #[ORM\Column(type: "text")]
    private string $message;

    #[ORM\Column(type: "string", length: 50, options: ["default" => ""])]
    private string $sender;

    #[ORM\Column(type: "integer", options: ["default" => 0])]
    private int $candidate_id;

    #[ORM\Column(type: "string", length: 50, options: ["default" => "candidate"])]
    private string $origin;

    #[ORM\Column(type: "datetime", options: ["default" => "CURRENT_TIMESTAMP"])]
    private \DateTimeInterface $send;

    public function __construct()
    {
        $this->sender = '';
        $this->candidate_id = 0;
        $this->origin = 'candidate';
        $this->send = new \DateTime();
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getMessage(): string
    {
        return $this->message;
    }

    public function setMessage(string $message): void
    {
        $this->message = $message;
    }

    public function getSender(): string
    {
        return $this->sender;
    }

    public function setSender(string $sender): void
    {
        $this->sender = $sender;
    }

    public function getCandidateId(): int
    {
        return $this->candidate_id;
    }

    public function setCandidateId(int $candidate_id): void
    {
        $this->candidate_id = $candidate_id;
    }

    public function getOrigin(): string
    {
        return $this->origin;
    }

    public function setOrigin(string $origin): void
    {
        $this->origin = $origin;
    }

    public function getSend(): \DateTimeInterface
    {
        return $this->send;
    }

    public function setSend(\DateTimeInterface $send): void
    {
        $this->send = $send;
    }
}

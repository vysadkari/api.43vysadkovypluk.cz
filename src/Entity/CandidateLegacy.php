<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity]
#[ORM\Table(name: "uchazec_uchazeci", uniqueConstraints: [new ORM\UniqueConstraint(name: "email", columns: ["email"])])]
class CandidateLegacy
{
    #[ORM\Id, ORM\GeneratedValue, ORM\Column(type: "integer")]
    private $id;

    #[ORM\Column(type: "string", length: 20, options: ["default" => "init"])]
    private $status;

    #[ORM\Column(type: "string", length: 255)]
    #[Assert\NotBlank(message: "Jméno je prázdné")]
    private $name;

    #[ORM\Column(type: "string", length: 50)]
    #[Assert\NotBlank(message: "Telefonní číslo je prázdné")]
    #[Assert\Regex(pattern: "/^(\+420)? ?[0-9]{3} ?[0-9]{3} ?[0-9]{3}$/", message: "Telefonní číslo není ve správném formátu")]
    private $tel;

    #[ORM\Column(type: "string", length: 255)]
    #[Assert\NotBlank(message: "Email je prázdný")]
    #[Assert\Email(message: "Email není ve správném formátu")]
    private $email;

    #[ORM\Column(type: "text", nullable: true)]
    private $notes;

    #[ORM\Column(type: "string", length: 100, options: ["default" => ""])]
    private $password;

    #[ORM\Column(type: "string", length: 43)]
    private $init_token;

    #[ORM\Column(type: "string", length: 10)]
    private $type;

    #[ORM\Column(type: "integer", options: ["default" => 0])]
    private $locked;

    #[ORM\Column(type: "integer", options: ["default" => 0])]
    private $failed_logins;

    #[ORM\Column(type: "datetime", columnDefinition: "DATETIME DEFAULT CURRENT_TIMESTAMP")]
    private $registered;

    #[ORM\Column(type: "datetime", columnDefinition: "DATETIME DEFAULT CURRENT_TIMESTAMP")]
    private $chat_last_read;

    public function __construct()
    {
        $this->status = 'init';
        $this->password = '';
        $this->init_token = '';
        $this->type = 'candidate';
        $this->locked = 0;
        $this->failed_logins = 0;
        $this->registered = new \DateTime();
        $this->chat_last_read = new \DateTime();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(string $status): self
    {
        $this->status = $status;

        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getTel(): ?string
    {
        return $this->tel;
    }

    public function setTel(string $tel): self
    {
        $this->tel = $tel;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getNotes(): ?string
    {
        return $this->notes;
    }

    public function setNotes(?string $notes): self
    {
        $this->notes = $notes;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    public function getInitToken(): ?string
    {
        return $this->init_token;
    }

    public function setInitToken(string $init_token): self
    {
        $this->init_token = $init_token;

        return $this;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getLocked(): ?int
    {
        return $this->locked;
    }

    public function setLocked(int $locked): self
    {
        $this->locked = $locked;

        return $this;
    }

    public function getFailedLogins(): ?int
    {
        return $this->failed_logins;
    }

    public function setFailedLogins(int $failed_logins): self
    {
        $this->failed_logins = $failed_logins;

        return $this;
    }

    public function getRegistered(): ?\DateTimeInterface
    {
        return $this->registered;
    }

    public function setRegistered(\DateTimeInterface $registered): self
    {
        $this->registered = $registered;

        return $this;
    }

    public function getChatLastRead(): ?\DateTimeInterface
    {
        return $this->chat_last_read;
    }

    public function setChatLastRead(\DateTimeInterface $chat_last_read): self
    {
        $this->chat_last_read = $chat_last_read;

        return $this;
    }
}

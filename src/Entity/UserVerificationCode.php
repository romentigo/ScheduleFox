<?php

namespace App\Entity;

use App\Repository\UserVerificationCodeRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

#[ORM\Entity(repositoryClass: UserVerificationCodeRepository::class)]
class UserVerificationCode
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $account = null;

    #[ORM\Column(length: 255)]
    private ?string $type = null;

    #[ORM\Column(length: 255)]
    private ?string $code_hash = null;

    #[ORM\Column]
    private ?\DateTime $expires_at = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTime $used_at = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAccount(): ?User
    {
        return $this->account;
    }

    public function setAccount(?User $account): static
    {
        $this->account = $account;

        return $this;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): static
    {
        $this->type = $type;

        return $this;
    }

    public function getCodeHash(): ?string
    {
        return $this->code_hash;
    }

    public function setCodeHash(string $code_hash): static
    {
        $this->code_hash = $code_hash;

        return $this;
    }

    public function getExpiresAt(): ?\DateTime
    {
        return $this->expires_at;
    }

    public function setExpiresAt(\DateTime $expires_at): static
    {
        $this->expires_at = $expires_at;

        return $this;
    }

    public function getUsedAt(): ?\DateTime
    {
        return $this->used_at;
    }

    public function setUsedAt(?\DateTime $used_at): static
    {
        $this->used_at = $used_at;

        return $this;
    }
}

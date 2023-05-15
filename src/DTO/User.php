<?php

namespace Teachbase\DTO;

use \DateTimeImmutable;

class User{

    private int $teachbaseId;
    private string $email;
    private ?string $phone;
    private string $name;
    private string $lastName;
    private int $roleId;
    private int $authType;
    private string $lang;
    private int $lastActivityAt;
    private bool $isActive;
    private DateTimeImmutable $createdAt;
    private DateTimeImmutable $updatedAt;
    private ?string $externalId;
    private bool $locked;
    private array $lables;

    public function getTeachbaseId(): int
    {
        return $this->teachbaseId;
    }

    public function setTeachbaseId(int $teachbaseId): self
    {
        $this->teachbaseId = $teachbaseId;

        return $this;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function setPhone(?string $phone): self
    {
        $this->phone = $phone;
        
        return $this;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;
        
        return $this;
    }

    public function getLastName(): string
    {
        return $this->lastName;
    }

    public function setLastName(string $lastName): self
    {
        $this->lastName = $lastName;
        
        return $this;
    }

    public function getRoleId(): int
    {
        return $this->roleId;
    }

    public function setRoleId(int $roleId): self
    {
        $this->roleId = $roleId;
        
        return $this;
    }

    public function getAuthType(): int
    {
        return $this->authType;
    }

    public function setAuthType(int $authType): self
    {
        $this->authType = $authType;
        
        return $this;
    }

    public function getLang(): string
    {
        return $this->lang;
    }

    public function setLang(string $lang): self
    {
        $this->lang = $lang;
        
        return $this;
    }

    public function getLastActivityAt(): int
    {
        return $this->getLastActivityAt;
    }

    public function setLastActivityAt(int $lastActivityAt): self
    {
        $this->lastActivityAt = $lastActivityAt;
        
        return $this;
    }

    public function getIsActive(): bool
    {
        return $this->isActive;
    }

    public function setIsActive(bool $isActive): self
    {
        $this->isActive = $isActive;
        
        return $this;
    }

    public function getCreatedAt(): DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(DateTimeImmutable $createdAt): self
    {
        $this->createdAt = $createdAt;
        
        return $this;
    }

    public function getUpdatedAt(): DateTimeImmutable
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(DateTimeImmutable $updatedAt): self
    {
        $this->updatedAt = $updatedAt;
        
        return $this;
    }

    public function getExternalId(): ?string
    {
        return $this->externalId;
    }

    public function setExternalId(?string $externalId): self
    {
        $this->externalId = $externalId;
        
        return $this;
    }

    public function getLocked(): bool
    {
        return $this->locked;
    }

    public function setLocked(bool $locked): self
    {
        $this->locked = $locked;
        
        return $this;
    }

    public function getLabels(): array
    {
        return $this->labels;
    }

    public function setLabelsa(array $lables): self
    {
        $this->lables = $lables;
        
        return $this;
    }
    
}